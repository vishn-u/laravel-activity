<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PipedrivePanelController extends Controller
{
    public function showPanel(Request $request)
    {
        $personId = $request->query('id');
        if (!$personId) {
            return "No person ID provided";
        }

        // 1. Get contact details from Pipedrive
        $pipedriveResponse = Http::get("https://api.pipedrive.com/v1/persons/{$personId}", [
            'api_token' => env('PIPEDRIVE_API_TOKEN')
        ]);

        if (!$pipedriveResponse->ok() || empty($pipedriveResponse->json('data'))) {
            return "Contact not found in Pipedrive.";
        }

        $person = $pipedriveResponse->json('data');
        $email = $person['email'][0]['value'] ?? null;

        if (!$email) {
            return "No email found for this contact.";
        }

        // 2. Call your internal transaction API
        $transactionsResponse = Http::get("https://octopus-app-3hac5.ondigitalocean.app/api", [
            'email' => $email
        ]);

        $transactions = $transactionsResponse->ok() ? $transactionsResponse->json() : [];

        // 3. Return view
        return view('pipedrive.panel', [
            'email' => $email,
            'transactions' => $transactions
        ]);
    }
}
