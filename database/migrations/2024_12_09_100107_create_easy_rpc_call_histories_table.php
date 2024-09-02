<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('easy_rpc_call_histories', function (Blueprint $table) {
            $table->id();
            $table->string('terminal')->nullable();
            $table->string('name')->nullable();
            $table->text('config')->nullable();
            $table->string('method')->nullable();
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('easy_rpc_call_histories');
    }
};
