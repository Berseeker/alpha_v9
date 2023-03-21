<?php

namespace App\Console\Commands;

use App\Jobs\Proveedores\InsertInnova;
use Illuminate\Console\Command;

class InnovaProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provider:innova';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iniciar el proceso automatico de Innova para sus productos';

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
        InsertInnova::dispatch();
        $this->info('Job Innova done at: ' . date('Y-m-d H:i:s'));

        return 0;
    }
}
