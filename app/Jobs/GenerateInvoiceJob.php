<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class GenerateInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(){}

    public function handle(): void
    {
        DB::table('payment_projections')->select(['id', 'name', 'email'])
            ->where(['generate_invoice' => 0])
            ->orderBy('id')
            ->chunk(1000, static function($items) {
                collect($items)->each(static function ($row) {
                    DB::table('payment_projections')
                        ->where('id', $row->id)
                        ->update(['generate_invoice' => 1]);
                });
            });
    }
}
