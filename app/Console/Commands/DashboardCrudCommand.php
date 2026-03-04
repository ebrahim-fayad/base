<?php

namespace App\Console\Commands;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Services\Command\Requestervice;
use Illuminate\Support\Facades\Artisan;
use App\Services\Command\DashboardCrud\RouteService;
use App\Services\Command\DashboardCrud\ControllerService;
use App\Services\Command\DashboardCrud\TranslationService;
use App\Services\Command\DashboardCrud\Blades\CreateBladesService;

class DashboardCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name=name} {arSingleName=arSingleName} {arpluraleName=arpluraleName} {--seed} {--request}';

    /**
     * The console command description.
     *
     * @var string
    */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $model         = $this->argument('name');

        $arSingleName  = $this->argument('arSingleName');
        $arpluraleName = $this->argument('arpluraleName');

        if ($this->confirm('sure you want to continue with name ' . $model, true)) {

            $folderName = strtolower(Str::plural(class_basename($model)));

            $singleName = strtolower(class_basename($model));

            // create Controller
               (new ControllerService)->createController($model, $folderName, $singleName, $arSingleName, $arpluraleName);
            // #create Controller

            // create folder and blade file
                (new CreateBladesService)->CreateBlades($folderName, $singleName);
            // create folder and blade file
               
            // create web routes
                (new RouteService)->createRoute($folderName, $singleName );
            // create web routes
            

            // create  translations at routes.php
                (new TranslationService)->createTranslation($folderName , $arSingleName , $arpluraleName , $singleName);
            // create  translations at routes.php
    
            // #create seeder (optional)
                if ($this->option('seed')) {
                    Artisan::call('make:seeder', ['name' => $model . 'TableSeeder']);
                }
            // #create seeder (optional)

            // create request (optional)
                if ($this->option('request')) {
                    (new Requestervice)->createRequest($model);
                }
            // #create request (optional)

            // call back
                $this->info('Dashboard Crud created successfully.');
            // #call back
        }
    }
}
