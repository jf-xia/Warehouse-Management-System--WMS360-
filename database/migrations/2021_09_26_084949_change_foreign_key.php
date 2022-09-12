<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_policies', function(Blueprint $table) {
//            $table->dropForeign('return_policies_account_id_foreign');
            DB::statement('ALTER TABLE return_policies DROP FOREIGN KEY IF EXISTS return_policies_account_id_foreign, DROP INDEX IF EXISTS return_policies_account_id_foreign');
                $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
        });

        Schema::table('shipment_policies', function(Blueprint $table) {
            DB::statement('ALTER TABLE shipment_policies DROP FOREIGN KEY IF EXISTS shipment_policies_account_id_foreign, DROP INDEX IF EXISTS shipment_policies_account_id_foreign');
//            $table->dropForeign('shipment_policies_account_id_foreign');
            $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
        });

        Schema::table('payment_policies', function(Blueprint $table) {
//            $table->dropForeign('payment_policies_account_id_foreign');
            DB::statement('ALTER TABLE payment_policies DROP FOREIGN KEY IF EXISTS payment_policies_account_id_foreign, DROP INDEX IF EXISTS payment_policies_account_id_foreign');
            $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
        });

        Schema::table('ebay_account_site', function(Blueprint $table) {
//            $table->dropForeign('ebay_account_site_account_id_foreign');
            DB::statement('ALTER TABLE ebay_account_site DROP FOREIGN KEY IF EXISTS ebay_account_site_account_id_foreign, DROP INDEX IF EXISTS ebay_account_site_account_id_foreign');
            $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
        });

        Schema::table('ebay_paypal_accounts', function(Blueprint $table) {
//            $table->dropForeign('ebay_paypal_accounts_account_id_foreign');
            DB::statement('ALTER TABLE ebay_paypal_accounts DROP FOREIGN KEY IF EXISTS ebay_paypal_accounts_account_id_foreign, DROP INDEX IF EXISTS ebay_paypal_accounts_account_id_foreign');
            $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
        });

        Schema::table('ebay_master_products', function(Blueprint $table) {
//            $table->dropForeign('ebay_master_products_account_id_foreign');
            DB::statement('ALTER TABLE ebay_master_products DROP FOREIGN KEY IF EXISTS ebay_master_products_account_id_foreign, DROP INDEX IF EXISTS ebay_master_products_account_id_foreign');
            DB::statement('ALTER TABLE ebay_master_products DROP FOREIGN KEY IF EXISTS ebay_master_products_profile_id_foreign, DROP INDEX IF EXISTS ebay_master_products_profile_id_foreign');
            $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('ebay_profiles')->onDelete('cascade');
        });

//        Schema::table('ebay_master_products', function(Blueprint $table) {
////            $table->dropForeign('ebay_master_products_account_id_foreign');
//            DB::statement('ALTER TABLE ebay_master_products DROP FOREIGN KEY IF EXISTS ebay_master_products_account_id_foreign, DROP INDEX IF EXISTS ebay_master_products_account_id_foreign');
//            $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
//        });

        Schema::table('ebay_profiles', function(Blueprint $table) {
//            $table->dropForeign('ebay_profiles_account_id_foreign');
            DB::statement('ALTER TABLE ebay_profiles DROP FOREIGN KEY IF EXISTS ebay_profiles_account_id_foreign, DROP INDEX IF EXISTS ebay_profiles_account_id_foreign');
            $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
        });

//        Schema::table('ebay_profiles', function(Blueprint $table) {
////            $table->dropForeign('ebay_profiles_account_id_foreign');
//            DB::statement('ALTER TABLE ebay_profiles DROP FOREIGN KEY IF EXISTS ebay_profiles_account_id_foreign, DROP INDEX IF EXISTS ebay_profiles_account_id_foreign');
//            $table->foreign('account_id')->references('id')->on('ebay_accounts')->onDelete('cascade');
//        });

        Schema::table('ebay_variation_products', function(Blueprint $table) {
//            $table->dropForeign('ebay_variation_products_ebay_master_product_id_foreign');
            DB::statement('ALTER TABLE ebay_variation_products DROP FOREIGN KEY IF EXISTS ebay_variation_products_ebay_master_product_id_foreign, DROP INDEX IF EXISTS ebay_variation_products_ebay_master_product_id_foreign');
            $table->foreign('ebay_master_product_id')->references('id')->on('ebay_master_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
