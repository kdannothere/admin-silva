<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DomainController extends Controller
{
    private $apiUrl = 'https://api.sandbox.namecheap.com/xml.response'; // Sandbox URL, remember to change for production

    public function index()
    {
        $domains = $this->getDomainsFromApi();

        if ($domains === null) {
            // Handle API error.  Log it, display a message, etc.
            return view('domains.index', ['domains' => [], 'error' => 'Error fetching domains from API.']);
        }

        return view('dashboard.domains', ['domains' => $domains]);
    }

    private function getDomainsFromApi()
    {
        $apiUser = "kdan"; // Store these securely in config files
        $apiKey = config('services.namecheap.api_key');
        $userName = "kdan"; // Usually same as api_user but separate in API
        $clientIp =  request()->ip(); // Get the client's IP.  Important for Namecheap API.

        // Example Domain List (You'll likely want to make this dynamic)
        $domainList = ['kdanhghghhgh.com'];  // Or get from database, user input, etc.

        $domainListString = implode(',', $domainList); // Comma-separated for the API

        $response = Http::get($this->apiUrl, [ // Query parameters (first argument)
            'ApiUser' => $apiUser,
            'ApiKey' => $apiKey,
            'UserName' => $userName,
            'ClientIp' => $clientIp,
            'Command' => 'namecheap.domains.check',
            'DomainList' => $domainListString,
        ]);
        // dd($response->body());
        if ($response->successful()) {
            $xml = simplexml_load_string($response->body());
            $domains = [];
    
            if (isset($xml->CommandResponse->DomainCheckResult)) {
                // Handle single and multiple DomainCheckResult elements
                $domainResults = is_array($xml->CommandResponse->DomainCheckResult) ?
                    $xml->CommandResponse->DomainCheckResult : [$xml->CommandResponse->DomainCheckResult];
    
                foreach ($domainResults as $domainResult) {
                    $domainName = (string)$domainResult['Domain']; // Access the Domain attribute using array syntax
                    $available = (string)$domainResult['Available'] == 'true';
    
                    $domains[] = [
                        'domain' => $domainName,
                        'available' => $available,
                    ];
                }
            } else {
                // Handle missing DomainCheckResult (check for errors as well)
                if (isset($xml->CommandResponse->Errors)) {
                    foreach ($xml->CommandResponse->Errors->Error as $error) {
                        Log::error("Namecheap API Error: " . $error->Number . " - " . $error->Text);
                    }
                } else {
                    Log::error("Unexpected Namecheap API Response: " . $response->body());
                }
            }

            // dd($domains);
            return $domains;
        } else {
            // Handle API errors (log, display message, etc.)
            Log::error("Namecheap API Error: " . $response->status() . " - " . $response->body());

            return null; // Or throw an exception
        }
    }
}
