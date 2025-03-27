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
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Código (ID)
            $table->string('full_name'); // Nome completo
            $table->string('nickname')->nullable(); // Apelido (opcional)
            $table->string('parent_name'); // Nome do pai/mãe
            $table->string('cpf', 14)->unique(); // CPF (formato: 000.000.000-00)
            $table->date('birth_date'); // Data de nascimento
            $table->string('position'); // Cargo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
