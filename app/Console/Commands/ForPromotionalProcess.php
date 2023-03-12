<?php

namespace App\Console\Commands;

use App\Jobs\Proveedores\InsertForPromotional;
use Illuminate\Console\Command;

class ForPromotionalProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provider:forpromotional';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iniciar el proceso automatico para actualizar los productos de ForPromotional';

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
        InsertForPromotional::dispatch();

        $this->info('Job ForPromotional done');
        
    }
}
