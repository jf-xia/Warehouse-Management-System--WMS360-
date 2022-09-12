<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Spatie\DbDumper\Databases\MySql;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Spatie\DbDumper\Databases\Sqlite;

class TestControllerTwo extends Controller
{
    public function test(){

        set_time_limit(50000);
//        File::cleanDirectory(storage_path('app/Laravel'));
//        Artisan::call('backup:run');

        $migration1 = new Process("git reset --hard");
        $migration2 = new Process("git pull git@gitlab.com:combosoft.ltd/wms-merge-with-master-app.git");
        $migration3 = new Process("php artisan migrate");

        $migration1->setWorkingDirectory(base_path());

        $migration2->setWorkingDirectory(base_path());
        $migration3->setWorkingDirectory(base_path());

        $migration1->run();
        $migration2->run();
        $migration3->run();

        if($migration1->isSuccessful()){
            //...
        } else {
            throw new ProcessFailedException($migration1);

        }

        if($migration2->isSuccessful()){
            //...
        } else {
            throw new ProcessFailedException($migration2);
        }

        if($migration3->isSuccessful()){
            //...
        } else {
            throw new ProcessFailedException($migration3);
        }
        return redirect('dashboard');
    }
    public function migrate(){
//        Log::info("migration started");
        $migration1 = new Process("php artisan migrate");
        $migration1->run();

        if($migration1->isSuccessful()){
            //...
        } else {
            throw new ProcessFailedException($migration1);

        }
//        Log::info("migration ended");
    }
}
