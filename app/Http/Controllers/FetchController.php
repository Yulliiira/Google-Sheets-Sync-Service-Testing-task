<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google\Client;
use Google\Service\Sheets;

use App\Models\SheetConfig;

class FetchController extends Controller
{
    public function fetch(Request $request, $count = 10)
    {
        $client = new Client();
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig(env('GOOGLE_SERVICE_ACCOUNT_JSON'), true);
        $service = new Sheets($client);

        $spreadsheetId = SheetConfig::latest()->first()->sheet_id ?? null;
        if (!$spreadsheetId) {
            return response('Sheet ID not found', 404);
        }

        $range = 'A2:G';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues() ?? [];

        $count = min((int)$count, count($values));
        $sliced = array_slice($values, 0, $count);

        return view('sheet_config.sheet_data', ['rows' => $sliced]);
    }
}
