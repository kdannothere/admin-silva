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
        $domainInput = $request->input('domain'); // Get the domains from the user input field
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

    public function registerDomainShow(Request $request)
    {
        $domainInput = $request->input('domain'); // Get the domains from the user input field

        return view('dashboard.register-domain', ['domain' => $domainInput]);
    }

    private function getDomainsFromApi($domainListString)
    {
        $apiUser = "kdan"; // Store these securely in config files
        $apiKey = config('services.namecheap.api_key');
        $userName = "kdan"; // Usually same as api_user but separate in API
        $clientIp =  request()->ip(); // Get the client's IP.  Important for Namecheap API.

        $response = Http::get($this->apiUrl, [ // Query parameters (first argument)
            'ApiUser' => $apiUser, // Global parameter, should be present in all requests
            'ApiKey' => $apiKey, // Global parameter, should be present in all requests
            'UserName' => $userName, // Global parameter, should be present in all requests
            'ClientIp' => $clientIp, // Global parameter, should be present in all requests
            'Command' => 'namecheap.domains.check',  // Global parameter, should be present in all requests. Use the check command to check availability of a list of domains
            'DomainList' => $domainListString, // a list of domains from user input
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

    public function registerDomain(Request $request)
    {

        // Validate the request data (important!)
        $validatedData = $request->validate([
            'domain' => 'required|string|max:70',
            'years' => 'required|integer|min:1',
            'nameservers' => 'nullable|string',
            'RegistrantFirstName' => 'required|string|max:255',
            'RegistrantLastName' => 'required|string|max:255',
            'RegistrantOrganizationName' => 'nullable|string|max:255',
            'RegistrantEmailAddress' => 'required|email|max:255',
            'RegistrantAddress1' => 'required|string|max:255',
            'RegistrantAddress2' => 'nullable|string|max:255',
            'RegistrantCity' => 'required|string|max:50',
            'RegistrantStateProvince' => 'required|string|max:50',
            'RegistrantPostalCode' => 'required|string|max:50',
            'RegistrantCountry' => 'required|string|size:2',
            'RegistrantPhone' => 'required|string|regex:/^\+[1-9]\d{1,2}\.\d{7,9}$/',
            'TechFirstName' => 'required|string|max:255',
            'TechLastName' => 'required|string|max:255',
            'TechOrganizationName' => 'nullable|string|max:255',
            'TechEmailAddress' => 'required|email|max:255',
            'TechAddress1' => 'required|string|max:255',
            'TechAddress2' => 'nullable|string|max:255',
            'TechCity' => 'required|string|max:50',
            'TechStateProvince' => 'required|string|max:50',
            'TechPostalCode' => 'required|string|max:50',
            'TechCountry' => 'required|string|size:2',
            'TechPhone' => 'required|string|regex:/^\+[1-9]\d{1,2}\.\d{7,9}$/',
            'AdminFirstName' => 'required|string|max:255',
            'AdminLastName' => 'required|string|max:255',
            'AdminOrganizationName' => 'nullable|string|max:255',
            'AdminEmailAddress' => 'required|email|max:255',
            'AdminAddress1' => 'required|string|max:255',
            'AdminAddress2' => 'nullable|string|max:255',
            'AdminCity' => 'required|string|max:50',
            'AdminStateProvince' => 'required|string|max:50',
            'AdminPostalCode' => 'required|string|max:50',
            'AdminCountry' => 'required|string|size:2',
            'AdminPhone' => 'required|string|regex:/^\+[1-9]\d{1,2}\.\d{7,9}$/',
            'AuxBillingFirstName' => 'required|string|max:255',
            'AuxBillingLastName' => 'required|string|max:255',
            'AuxBillingOrganizationName' => 'nullable|string|max:255',
            'AuxBillingEmailAddress' => 'required|email|max:255',
            'AuxBillingAddress1' => 'required|string|max:255',
            'AuxBillingAddress2' => 'nullable|string|max:255',
            'AuxBillingCity' => 'required|string|max:50',
            'AuxBillingStateProvince' => 'required|string|max:50',
            'AuxBillingPostalCode' => 'required|string|max:50',
            'AuxBillingCountry' => 'required|string|size:2',
            'AuxBillingPhone' => 'required|string|regex:/^\+[1-9]\d{1,2}\.\d{7,9}$/',
            'AddFreeWhoisguard' => 'required|string|max:10',
            'WGEnabled' => 'required|string|max:10',
            'IsPremiumDomain' => 'required|string|in:true,false',
        ]);

        $registrationResult = $this->registerDomainWithApi($validatedData);

        if ($registrationResult && $registrationResult['success']) {
            return redirect("dashboard")->with('success', "Domain {$validatedData['domain']} registered successfully!");
        } else {
            return redirect("dashboard")->with('error', "Domain registration failed: " . $registrationResult['error'] ?? 'Unknown Error');
        }
    }

    private function registerDomainWithApi($validatedData)
    {
        $apiUser = "kdan";
        $apiKey = config('services.namecheap.api_key');
        $userName = "kdan";
        $clientIp = request()->ip();

        $response = Http::get($this->apiUrl, [
            'ApiUser' => $apiUser, // Global parameter, should be present in all requests
            'ApiKey' => $apiKey, // Global parameter, should be present in all requests
            'UserName' => $userName, // Global parameter, should be present in all requests
            'ClientIp' => $clientIp, // Global parameter, should be present in all requests
            'Command' => 'namecheap.domains.create', // Global parameter, should be present in all requests. Use the create command to register a domain
            'DomainName' => $validatedData['domain'], // (Required. Type: String. Max length: 70.) - Domain name to register
            'Nameservers' => $validatedData['nameservers'], // (Optional. Type: String.) - Comma-separated list of custom nameservers to be associated with the domain name
            'Years' => $validatedData['years'], // (Required. Type: Number. Max length: 20.) - Number of years to register. Default Value: 2
            'RegistrantOrganizationName' => $validatedData['RegistrantOrganizationName'], // (Optional. Type: String. Max length: 255.) - Organization of the Registrant user
            'RegistrantFirstName' => $validatedData['RegistrantFirstName'], // (Required. Type: String. Max length: 255.) - First name of the Registrant user
            'RegistrantLastName' => $validatedData['RegistrantLastName'], // (Required. Type: String. Max length: 255.) - Second name of the Registrant user
            'RegistrantAddress1' => $validatedData['RegistrantAddress1'], // (Required. Type: String. Max length: 255.) - Address1 of the Registrant user
            'RegistrantAddress2' => $validatedData['RegistrantAddress2'], // (Optional. Type: String. Max length: 255.) - Address2 of the Registrant user
            'RegistrantCity' => $validatedData['RegistrantCity'], // (Required. Type: String. Max length: 50.) - City of the Registrant user
            'RegistrantStateProvince' => $validatedData['RegistrantStateProvince'], // (Required. Type: String. Max length: 50.) - State/Province of the Registrant user
            'RegistrantPostalCode' => $validatedData['RegistrantPostalCode'], // (Required. Type: String. Max length: 50.) - PostalCode of the Registrant user
            'RegistrantCountry' => $validatedData['RegistrantCountry'], // (Required. Type: String. Max length: 50.) - Country of the Registrant user (2-letter country code)
            'RegistrantPhone' => $validatedData['RegistrantPhone'], // (Required. Type: String. Max length: 50.) - Phone number in the format +NNN.NNNNNNNNNN (including country code)
            'RegistrantEmailAddress' => $validatedData['RegistrantEmailAddress'], // (Required. Type: String. Max length: 255.) - Email address of the Registrant user
            'TechOrganizationName' => $validatedData['TechOrganizationName'], // (Optional. Type: String. Max length: 255.) - Organization of the Tech user
            'TechFirstName' => $validatedData['TechFirstName'], // (Required. Type: String. Max length: 255.) - First name of the Tech user
            'TechLastName' => $validatedData['TechLastName'], // (Required. Type: String. Max length: 255.) - Second name of the Tech user
            'TechAddress1' => $validatedData['TechAddress1'], // (Required. Type: String. Max length: 255.) - Address1 of the Tech user
            'TechAddress2' => $validatedData['TechAddress2'], // (Optional. Type: String. Max length: 255.) - Address2 of the Tech user
            'TechCity' => $validatedData['TechCity'], // (Required. Type: String. Max length: 50.) - City of the Tech user
            'TechStateProvince' => $validatedData['TechStateProvince'], // (Required. Type: String. Max length: 50.) - State/Province of the Tech user
            'TechPostalCode' => $validatedData['TechPostalCode'], // (Required. Type: String. Max length: 50.) - PostalCode of the Tech user
            'TechCountry' => $validatedData['TechCountry'], // (Required. Type: String. Max length: 50.) - Country of the Tech user (2-letter country code)
            'TechPhone' => $validatedData['TechPhone'], // (Required. Type: String. Max length: 50.) - Phone number in the format +NNN.NNNNNNNNNN (including country code)
            'TechEmailAddress' => $validatedData['TechEmailAddress'], // (Required. Type: String. Max length: 255.) - Email address of the Tech user
            'AdminOrganizationName' => $validatedData['AdminOrganizationName'], // (Optional. Type: String. Max length: 255.) - Organization of the Admin user
            'AdminFirstName' => $validatedData['AdminFirstName'], // (Required. Type: String. Max length: 255.) - First name of the Admin user
            'AdminLastName' => $validatedData['AdminLastName'], // (Required. Type: String. Max length: 255.) - Second name of the Admin user
            'AdminAddress1' => $validatedData['AdminAddress1'], // (Required. Type: String. Max length: 255.) - Address1 of the Admin user
            'AdminAddress2' => $validatedData['AdminAddress2'], // (Optional. Type: String. Max length: 255.) - Address2 of the Admin user
            'AdminCity' => $validatedData['AdminCity'], // (Required. Type: String. Max length: 50.) - City of the Admin user
            'AdminStateProvince' => $validatedData['AdminStateProvince'], // (Required. Type: String. Max length: 50.) - State/Province of the Admin user
            'AdminPostalCode' => $validatedData['AdminPostalCode'], // (Required. Type: String. Max length: 50.) - PostalCode of the Admin user
            'AdminCountry' => $validatedData['AdminCountry'], // (Required. Type: String. Max length: 50.) - Country of the Admin user (2-letter country code)
            'AdminPhone' => $validatedData['AdminPhone'], // (Required. Type: String. Max length: 50.) - Phone number in the format +NNN.NNNNNNNNNN (including country code)
            'AdminEmailAddress' => $validatedData['AdminEmailAddress'], // (Required. Type: String. Max length: 255.) - Email address of the Admin user
            'AuxBillingOrganizationName' => $validatedData['AuxBillingOrganizationName'], // (Optional. Type: String. Max length: 255.) - Organization of the AuxBilling user
            'AuxBillingFirstName' => $validatedData['AuxBillingFirstName'], // (Required. Type: String. Max length: 255.) - First name of the AuxBilling user
            'AuxBillingLastName' => $validatedData['AuxBillingLastName'], // (Required. Type: String. Max length: 255.) - Second name of the AuxBilling user
            'AuxBillingAddress1' => $validatedData['AuxBillingAddress1'], // (Required. Type: String. Max length: 255.) - Address1 of the AuxBilling user
            'AuxBillingAddress2' => $validatedData['AuxBillingAddress2'], // (Optional. Type: String. Max length: 255.) - Address2 of the AuxBilling user
            'AuxBillingCity' => $validatedData['AuxBillingCity'], // (Required. Type: String. Max length: 50.) - City of the AuxBilling user
            'AuxBillingStateProvince' => $validatedData['AuxBillingStateProvince'], // (Required. Type: String. Max length: 50.) - State/Province of the AuxBilling user
            'AuxBillingPostalCode' => $validatedData['AuxBillingPostalCode'], // (Required. Type: String. Max length: 50.) - PostalCode of the AuxBilling user
            'AuxBillingCountry' => $validatedData['AuxBillingCountry'], // (Required. Type: String. Max length: 50.) - Country of the AuxBilling user (2-letter country code)
            'AuxBillingPhone' => $validatedData['AuxBillingPhone'], // (Required. Type: String. Max length: 50.) - Phone number in the format +NNN.NNNNNNNNNN (including country code)
            'AuxBillingEmailAddress' => $validatedData['AuxBillingEmailAddress'], // (Required. Type: String. Max length: 255.) - Email address of the AuxBilling user
            'AddFreeWhoisguard' => $validatedData['AddFreeWhoisguard'], // (Optional. Type: String. Max length: 10.) - Adds free domain privacy for the domain. Default Value: no
            'WGEnabled' => $validatedData['WGEnabled'], // (Optional. Type: String. Max length: 10.) - Enables free domain privacy for the domain. Default Value: no
            'IsPremiumDomain' => $validatedData['IsPremiumDomain'], // (Optional. Type: Boolean. Max length: 10.) - Indication if the domain name is premium
        ]);

        if ($response->successful()) {
            $xmlString = $response->body();
            $dom = new DOMDocument();
            $dom->loadXML($xmlString);

            // Get the ApiResponse element (top-level)
            $apiResponse = $dom->getElementsByTagName('ApiResponse')->item(0);

            if ($apiResponse) {
                $statusNode = $apiResponse->attributes->getNamedItem('Status'); // Get Status from ApiResponse
                $status = $statusNode ? $statusNode->nodeValue : null;

                if ($status === 'ERROR') { // Check for ERROR status
                    $errorsNode = $apiResponse->getElementsByTagName('Errors')->item(0); // Get the Errors node
                    if ($errorsNode) {
                        $errorNode = $errorsNode->getElementsByTagName('Error')->item(0); // Get the first Error node
                        $errorMessage = $errorNode ? $errorNode->nodeValue : 'Domain registration failed.';

                        // Now you have the detailed error message
                        return ['success' => false, 'error' => $errorMessage];
                    } else {
                        return ['success' => false, 'error' => 'ApiResponse status is ERROR but no Errors node found.'];
                    }
                } elseif ($status === 'OK') {
                    $commandResponse = $dom->getElementsByTagName('CommandResponse')->item(0);
                    if ($commandResponse) {
                        $createResult = $commandResponse->getElementsByTagName('DomainCreateResult')->item(0);
                        if ($createResult) {
                            // Correctly check the 'Registered' attribute of DomainCreateResult
                            $registeredNode = $createResult->attributes->getNamedItem('Registered');
                            $registered = $registeredNode ? $registeredNode->nodeValue : null;

                            if ($registered === 'true') { // Important: Check for the string "true"
                                return ['success' => true];
                            } else {
                                // Domain registration failed.  Try to get the error if available.
                                $errorNode = $createResult->getElementsByTagName('Error')->item(0); // Check for error within DomainCreateResult
                                $errorMessage = $errorNode ? $errorNode->nodeValue : 'Domain registration failed.'; // More specific message
                                return ['success' => false, 'error' => $errorMessage];
                            }
                        } else {
                            return ['success' => false, 'error' => 'Missing DomainCreateResult in response.'];
                        }
                    }
                } else {
                    return ['success' => false, 'error' => 'Unexpected ApiResponse status: ' . $status];
                }
            } else {
                return ['success' => false, 'error' => 'Invalid XML response format.'];
            }
        } else {
            Log::error("Namecheap API Error: " . $response->status() . " - " . $response->body());
            return ['success' => false, 'error' => "API Error: " . $response->status() . " - " . $response->body()]; // Include response body for debugging
        }
    }
}
