<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('address');
            $table->text('description')->nullable();
            $table->boolean('is_available')->default(true); 
            $table->enum('status', ['active', 'inactive'])->default('active'); 
            $table->decimal('price', 10, 2);
            $table->integer('capacity')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rooms');
    }
};
