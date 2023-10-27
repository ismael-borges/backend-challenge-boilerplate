<?php

namespace App\Console\Commands;

use App\Models\ScheduleImport;
use App\Repositorys\PaymentProjectionRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Exception;
use League\Csv\Reader;

class ImportPaymentProjectionsCommand extends Command
{
    protected $signature = 'import:csv';
    protected $description = 'Importer CSV';

    /**
     * @throws Exception
     * @throws \Throwable
     */
    public function handle(): void
    {
        $start_time = microtime(true);
        $this->output->title('Starting import');

        $csv = Reader::createFromString(Storage::get(ScheduleImport::find(1)->path));
        $csv->setHeaderOffset(0);

        collect($csv)
            ->chunk(5000)
            ->each(static function($chunk) {
                $bulkInsert = [];
                $chunk->each(static function ($row) use (&$bulkInsert) {
                    $row['created_at'] = date('Y-m-d');
                    $row['updated_at'] = date('Y-m-d');
                    $bulkInsert[] = $row;
                });
                DB::table('payment_projections')->insert($bulkInsert);
                $bulkInsert = [];
            });

        $end_time = microtime(true);
        $execution_time = $end_time - $start_time;
        $this->output->success("Tempo de execução: " . $execution_time . " segundos");

        (new PaymentProjectionRepository)->update(1, [
            'execute_time' => $execution_time,
            'execute' => 1,
        ]);
    }
}
