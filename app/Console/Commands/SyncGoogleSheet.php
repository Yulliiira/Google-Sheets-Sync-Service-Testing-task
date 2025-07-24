<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Google\Client;
use Google\Service\Sheets;

use App\Models\Record;
use App\Models\SheetConfig;

class SyncGoogleSheet extends Command
{
    protected $signature = 'sync:google-sheet';

    protected $description = 'Синхронизирует записи из Google Sheets в БД';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Синхронизация началась...');

        $client = new Client();
        $client->setAuthConfig(env('GOOGLE_SERVICE_ACCOUNT_JSON'));
        $client->addScope(Sheets::SPREADSHEETS_READONLY);

        $service = new Sheets($client);
        $spreadsheetId = SheetConfig::latest()->first()->sheet_id ?? null;
        $range = 'A2:F';

        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            $this->warn('Нет данных в таблице.');
            return 0;
        }

        foreach ($values as $row) {
            if (empty($row[0]) || empty($row[1])) {
                $this->warn('Пропущена строка из-за отсутствия ID или Title');
                continue;
            }

            $status = $row[2] ?? null;
            if (!in_array($status, ['Allowed', 'Prohibited'])) {
                $this->warn("Пропущена строка ID={$row[0]}: неверный статус '$status'");
                continue;
            }

            Record::updateOrCreate(
                ['id' => $row[0]],
                [
                    'title' => $row[1],
                    'status' => $status,
                    'content' => $row[3] ?? null,
//                    'comment' => $row[6] ?? null,
                ]
            );
        }

        $this->info('Синхронизация завершена.');
        return 0;
    }
}
