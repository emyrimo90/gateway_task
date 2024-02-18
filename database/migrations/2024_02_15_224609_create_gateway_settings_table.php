<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('TEST')->comment("TEST, PRODUCTION");
            $table->mediumText('client_id')->nullable();//key
            $table->mediumText('client_secret')->nullable();
            $table->boolean('status')->default(0);
            $table->string('response_url')->default('success-transaction');
            $table->string('cancel_url')->default('cancel_url');
            $table->string('currency')->default('USD');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gateway_settings');
    }
};
