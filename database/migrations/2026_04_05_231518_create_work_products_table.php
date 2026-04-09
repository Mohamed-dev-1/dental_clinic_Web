<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('work_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistant_id')->constrained('assistants')->onDelete('cascade');
            $table->string('material_name');
            $table->integer('material_qty');
            $table->integer('material_unit_price');
            $table->date('material_expiration_date')->nullable();
            $table->boolean('material_low_stock_alert')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_products');
    }
};
