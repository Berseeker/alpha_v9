<?php

namespace App\Console\Commands;

use App\Jobs\Proveedores\InsertPromoOpcion;
use Illuminate\Console\Command;

class PromoOpcionProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provider:promoopcion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iniciar el proceso automatico de Promo Opcion de sus productos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        InsertPromoOpcion::dispatch();
        $this->info('Job Promo Opcion done at: ' . date('Y-m-d H:i:s'));
        
        return 0;
    }
}
