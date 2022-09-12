<?php


namespace App\Traits;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

trait CustomMigration
{
    public function forceDeleteTable($table_name){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists($table_name);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
    public function forceDeleteColumn($column_name,$table_name){
        $this->column = $column_name;
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table($table_name, function($table) {
            $table->dropColumn($this->column);
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
