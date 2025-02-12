<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    private $apiUrl = 'https://api.sandbox.namecheap.com/xml.response'; // Sandbox URL, remember to change for production

    public function index(Request $request)
    {
        $domainInput = $request->input('domain'); // Get the domain from the user input field
        $domains = [];
        $error = null;

        if ($domainInput) { // Check if the domain input is not empty
            $domainList = explode(',', $domainInput); // Split the input string by commas
            $domainList = array_map('trim', $domainList); // Trim whitespace from each domain
            $domainListString = implode(',', $domainList);

            $domains = $this->getDomainsFromApi($domainListString);

            if ($domains === null) {
                $error = 'Error fetching domains from API.';
            }
        } else {
            $error = 'Please enter at least one domain.';
        }


        return view('dashboard.domains', ['domains' => $domains, 'error' => $error, 'domainInput' => $domainInput]); // Pass the domains and error to the view
    }

    private function getDomainsFromApi($domainListString)
    {
        $apiUser = "kdan"; // Store these securely in config files
        $apiKey = config('services.namecheap.api_key');
        $userName = "kdan"; // Usually same as api_user but separate in API
        $clientIp =  request()->ip(); // Get the client's IP.  Important for Namecheap API.

        $response = Http::get($this->apiUrl, [ // Query parameters (first argument)
            'ApiUser' => $apiUser,
            'ApiKey' => $apiKey,
            'UserName' => $userName,
            'ClientIp' => $clientIp,
            'Command' => 'namecheap.domains.check',
            'DomainList' => $domainListString,
        ]);
        if ($response->successful()) {
            $xmlString = $response->body(); // Get the XML string
            $dom = new DOMDocument();
            $dom->loadXML($xmlString); // Load the XML string

            $domains = [];

            $domainResults = $dom->getElementsByTagName('DomainCheckResult'); // Get all DomainCheckResult elements

            foreach ($domainResults as $domainResult) {
                $domainName = null;
                $available = null;

                // Get Domain attribute (defensive)
                $domainNode = $domainResult->attributes->getNamedItem('Domain');
                if ($domainNode) {
                    $domainName = $domainNode->nodeValue;
                }

                // Get Available attribute (defensive)
                $availableNode = $domainResult->attributes->getNamedItem('Available');
                if ($availableNode) {
                    $available = $availableNode->nodeValue == 'true';
                }

                // Only add to the $domains array if both values are available
                if ($domainName !== null && $available !== null) {
                    $domains[] = [
                        'domain' => $domainName,
                        'available' => $available,
                    ];
                } else {
                    Log::warning("Incomplete DomainCheckResult data: " . $domainResult->C14N()); // Log the problematic XML element
                }
            }


            return $domains;
        } else {
            // Handle API errors (log, display message, etc.)
            Log::error("Namecheap API Error: " . $response->status() . " - " . $response->body());

            return null; // Or throw an exception
        }
    }
}
