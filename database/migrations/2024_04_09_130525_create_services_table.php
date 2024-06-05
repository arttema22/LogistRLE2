<?php

use App\Models\Route;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('date');
            $table->BigInteger('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('moonshine_users');
            $table->BigInteger('driver_id')->unsigned();
            $table->foreign('driver_id')->references('id')->on('moonshine_users');
            $table->BigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('dir_services');
            $table->boolean('is_route')->default(0);
            $table->foreignIdFor(Route::class)->nullable()->default(0);
            $table->string('comment')->nullable();
            $table->BigInteger('profit_id')->unsigned()->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
