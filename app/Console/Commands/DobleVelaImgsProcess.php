<?php

namespace App\Console\Commands;

use App\Jobs\Proveedores\UpdateImgDobleVela;
use Illuminate\Console\Command;

class DobleVelaImgsProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provider:doblevelaimgs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iniciar el proceso automatico Doble Vela para insertar imagenes de los productos';

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
        UpdateImgDobleVela::dispatch();
        $this->info('Job DobleVela Imgs done at: ' . date('Y-m-d H:i:s'));

        return 0;
    }
}
