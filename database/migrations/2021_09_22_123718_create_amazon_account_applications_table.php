<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmazonAccountApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazon_account_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('amazon_account_id');
            $table->string('application_name');
            $table->text('application_id');
            $table->text('iam_arn')->comment('role of the iam arn');
            $table->text('lwa_client_id')->comment('credential of the app when created');
            $table->text('lwa_client_secret')->comment('credential of the app when created');
            $table->text('aws_access_key_id')->comment('credential of the role arn when created');
            $table->text('aws_secret_access_key')->comment('credential of the role arn when created');
            $table->unsignedBigInteger('amazon_marketplace_fk_id');
            $table->text('oauth_login_url')->nullable();
            $table->text('oauth_redirect_url')->comment('redirect url of your app after authorization');
            $table->tinyInteger('application_status')->comment('0=inactive,1=active');
            $table->tinyInteger('is_authorize')->default(0)->comment('1=authorized,0=pending authorization');
            $table->text('application_logo')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('amazon_account_id')->references('id')->on('amazon_accounts');
            $table->foreign('amazon_marketplace_fk_id')->references('id')->on('amazon_market_places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amazon_account_applications');
    }
}
