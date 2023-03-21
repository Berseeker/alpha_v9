<?php

namespace App\Console\Commands;

use App\Jobs\Proveedores\InsertDobleVela;
use Illuminate\Console\Command;

class DobleVelaProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provider:doblevela';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iniciar el proceso automatico para los productos de Doble Vela';

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
        InsertDobleVela::dispatch();

        $this->info('Job Doble Vela done at: ' . date('Y-m-d H:i:s') );

        return 0;
    }
}
