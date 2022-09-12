<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVersionColumnToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    use \App\Traits\CustomMigration;
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->longText('old_version');
            $table->longText('new_version');
            $table->integer('old_migration_count');
            $table->integer('new_migration_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->forceDeleteColumn('old_version','clients');
        $this->forceDeleteColumn('new_version','clients');
        $this->forceDeleteColumn('old_migration_count','clients');
        $this->forceDeleteColumn('new_migration_count','clients');
    }
}
