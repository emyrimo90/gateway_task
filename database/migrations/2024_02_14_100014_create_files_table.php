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
    public function up(): void
    {
        Schema::create('files', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ext', 10);
            $table->string('url');
            $table->string('type')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('mime')->nullable();
            $table->string('duration')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('custom_name')->nullable();
            $table->longText('notes')->nullable();
            $table->nullableMorphs('fileable');
            $table->timestamps();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
