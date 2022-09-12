<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
class TestController extends Controller
{
    public function index(){
        $result = exec('git for-each-ref --sort=taggerdate --format "%(tag)" --sort=-taggerdate --count=6',$tags,$exit_status);
        if ($exit_status) {
            $tags = null;
        }

        $migration0 = new Process("git fetch git@gitlab.com:combosoft.ltd/wms-merge-with-master-app.git --tags");
        $migration0->setWorkingDirectory(base_path());
        $value = exec('git rev-list --tags --max-count=1');
        $migration0->run();
//
        if($migration0->isSuccessful()){

        } else {
            throw new ProcessFailedException($migration0);

        }

        $latest_version = exec('git describe --tags '.$value);

        $current_version = trim(exec('git describe --tags --abbrev=0'));
        $stable_version = Client::find(1)->old_version;
        //
        return view('update.index',compact('latest_version','stable_version','current_version','tags'));
    }

    function execute($cmd, $workdir = null) {

        if (is_null($workdir)) {
            $workdir = __DIR__;
        }

        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin
            1 => array("pipe", "w"),  // stdout
            2 => array("pipe", "w"),  // stderr
        );

        $process = proc_open($cmd, $descriptorspec, $pipes, $workdir, null);

        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        return [
            'code' => proc_close($process),
            'out' => trim($stdout),
            'err' => trim($stderr),
        ];
    }
    public function test(Request $request,$type){
        $new_version = $request->new_version ?? null;
        if ($type == "latest"){
            $current_version_name = trim(exec('git describe --tags --abbrev=0'));
            if ($current_version_name != $new_version){
                $this->updateVersionInfo($current_version_name,"old");
            }

            $migration0 = new Process("git fetch git@gitlab.com:combosoft.ltd/wms-merge-with-master-app.git --tags");
            $migration1 = new Process("git reset --hard");
            $migration2 = new Process("git checkout tags/".$new_version);
            $migration3 = new Process("php artisan migrate --force");

            $migration0->setWorkingDirectory(base_path());
            $migration1->setWorkingDirectory(base_path());

            $migration2->setWorkingDirectory(base_path());
            $migration3->setWorkingDirectory(base_path());

            $migration0->run();
            $migration1->run();
            $migration2->run();
            $migration3->run();

            if($migration0->isSuccessful()){
                //...
            } else {
                throw new ProcessFailedException($migration1);

            }
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
            $this->updateVersionInfo($new_version,'new');
        }elseif ($type == "revert"){
            $client = Client::find(1);
            $current_migration_count = DB::table('migrations')->count();
            if (isset($client->old_version)){
                $migration0 = new Process("git fetch git@gitlab.com:combosoft.ltd/wms-merge-with-master-app.git --tags");
                $migration1 = new Process("git reset --hard");
                $migration2 = new Process("git checkout tags/".$client->old_version);
                $migration4 = new Process("php artisan migrate --force");
                $migration0->setWorkingDirectory(base_path());
                $migration1->setWorkingDirectory(base_path());

                $migration2->setWorkingDirectory(base_path());
                $migration4->setWorkingDirectory(base_path());


                $migration0->run();
                $migration1->run();
                $migration2->run();
                $migration4->run();


                if($migration0->isSuccessful()){
                    //...
                } else {
                    throw new ProcessFailedException($migration1);

                }
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
                if($migration4->isSuccessful()){
                    //...
                } else {
                    throw new ProcessFailedException($migration4);
                }
                $count =$current_migration_count - $client->old_migration_count;
                if ($count > 0){
                    $migration3 = new Process("php artisan migrate:rollback --step=".$count);
                    $migration3->setWorkingDirectory(base_path());
                    $migration3->run();

                    if($migration3->isSuccessful()){

                    } else {
                        throw new ProcessFailedException($migration3);
                    }
                }
            }
        }

//        File::cleanDirectory(storage_path('app/Laravel'));
//        Artisan::call('backup:run');




        return redirect('dashboard');
    }

    public function updateVersionInfo($version,$type){

        $migration_count = DB::table('migrations')->count();

        $client = Client::find(1);
        if ($type == "old"){
            $client->old_version = $version;
            $client->old_migration_count = $migration_count;
        }
        $client->save();
    }
    public function migrate(){
//        Log::info("migration started");
        $migration1 = new Process("php artisan migrate");
        $migration1->run();
        $migration2 = new Process("php artisan passport:client --personal --no-interaction");
        $migration2->run();


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
        $folderPath = 'uploads/product-images/';
        $path = base_path($folderPath);
        if(!is_dir($path)){
            mkdir($path);
        }
//        Log::info("migration ended");
    }
}
