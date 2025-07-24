<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Google\Client;
use Google\Service\Sheets;

class FetchGoogleSheet extends Command
{
    protected $signature = 'sheet:fetch {--count=10}';

    protected $description = 'Получение данных из Google Sheet и отображение их в консоли';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client();
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig(env('GOOGLE_SERVICE_ACCOUNT_JSON'), true);
        $service = new Sheets($client);

        $spreadsheetId = \App\Models\SheetConfig::latest()->first()->sheet_id ?? null;

        if (!$spreadsheetId) {
            $this->error('Sheet ID not found.');
            return 1;
        }

        $range = 'A2:G';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues() ?? [];

        $count = min((int) $this->option('count'), count($values));

        $this->info("Fetching $count rows from Google Sheet...\n");

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        foreach (array_slice($values, 0, $count) as $row) {
            $row = array_pad($row, 7, '');
            $bar->advance();

            $id       = $row[0] ?? '—';
            $title    = $row[1] ?? '—';
            $status   = $row[3] ?? '—';
            $comment  = $row[6] ?? '<UNK>';

            usleep(100_000);

            $this->line("\nID: $id | Title: $title | Status: $status | Comment: $comment");
        }

        $bar->finish();
        $this->info("\nDone.");

        return 0;
    }
}
