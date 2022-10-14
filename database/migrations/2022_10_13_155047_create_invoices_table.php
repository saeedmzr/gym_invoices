<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Club::class);
            $table->integer('amount')->default(0);
            $table->longText('description')->nullable();
            $table->json('invoice_lines')->nullable();
            $table->enum('status', ['Outstanding', 'Paid', 'Void'])->default('Outstanding');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
