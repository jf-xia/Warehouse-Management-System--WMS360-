<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('action_url')->nullable();
            $table->string('action_name')->nullable();
            $table->string('account_name')->nullable();
            $table->integer('account_id')->nullable();
            $table->longText('request_data')->nullable();
            $table->longText('response_data')->nullable();
            $table->string('action_by')->nullable();
            $table->integer('last_quantity')->nullable();
            $table->integer('updated_quantity')->nullable();
            $table->timestamp('action_date')->nullable();
            $table->integer('solve_status')->default(0)->comment('not_solved=0,solved=1,other=2');
            $table->integer('action_status')->nullable()->comment('error=0,success=1,unknown=2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
