<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\GoogleSheetService;

class ExportToGoogleSheet extends Command
{
    protected $signature = 'sheet:export';

    protected $description = 'Экспортирует записи в Google Sheet';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Начинаю экспорт...');

        try {
            app(GoogleSheetService::class)->syncRecordsToSheet();
            $this->info('Экспорт завершен!');
        } catch (\Exception $e) {
            $this->error('Ошибка: ' . $e->getMessage());
        }

        return 0;
    }
}
