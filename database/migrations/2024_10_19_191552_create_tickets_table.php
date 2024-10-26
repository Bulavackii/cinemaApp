<?php

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
        // Убедимся, что таблица tickets создается единожды
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // ID билета
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Внешний ключ на таблицу пользователей
            $table->foreignId('seance_id')->constrained('seances')->onDelete('cascade'); // Внешний ключ на таблицу сеансов
            $table->integer('seat_row'); // Номер ряда
            $table->integer('seat_number'); // Номер места
            $table->string('qr_code')->nullable(); // QR-код билета
            $table->timestamps(); // Время создания и обновления
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
