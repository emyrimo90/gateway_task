<?php

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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no')->nullable();
            $table->mediumText('trace_id');
            $table->string('status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('currency')->default('USD');
            $table->decimal('amount', 10, 2);
            $table->text('comment')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('data')->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('set null')
                ->onDelete('set null');

             $table->foreignId('gateway_setting_id')
                ->nullable()
                ->constrained('gateway_settings')
                ->onUpdate('set null')
                ->onDelete('set null');

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
        Schema::dropIfExists('transactions');
    }
};
