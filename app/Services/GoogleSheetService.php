<?php

namespace App\Services;

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ClearValuesRequest;
use Google\Service\Sheets\ValueRange;

use App\Models\Record;
use App\Models\SheetConfig;

class GoogleSheetService
{
    protected Sheets $service;
    protected string $spreadsheetId;

    public function __construct()
    {
        $client = new Client();
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig(env('GOOGLE_SERVICE_ACCOUNT_JSON'), true);
        $this->service = new Sheets($client);

        $this->spreadsheetId = SheetConfig::latest()->first()->sheet_id ?? '';
    }

    public function syncRecordsToSheet(): void
    {
        $records = Record::allowed()->get(['id', 'title', 'content', 'status', 'created_at']);

        $commentsResponse = $this->service->spreadsheets_values->get($this->spreadsheetId, 'G2:G');
        $comments = $commentsResponse->getValues() ?? [];

        $commentsMap = [];
        foreach ($comments as $i => $row) {
            $commentsMap[$i] = $row[0] ?? '';
        }

        $newData = [];
        foreach ($records as $i => $record) {
            $newData[] = [
                $record->id,
                $record->title,
                $record->content,
                $record->status,
                $record->created_at->toDateTimeString(),
                $commentsMap[$i] ?? '',
            ];
        }

        $this->service->spreadsheets_values->clear($this->spreadsheetId, 'A2:G', new ClearValuesRequest());
        $body = new ValueRange([

            'range' => 'A2:F',
            'values' => array_map(fn($row) => array_slice($row, 0, 6), $newData),
        ]);

        $this->service->spreadsheets_values->update(
            $this->spreadsheetId,
            'A2:F',
            $body,
            ['valueInputOption' => 'RAW']
        );
    }
}
