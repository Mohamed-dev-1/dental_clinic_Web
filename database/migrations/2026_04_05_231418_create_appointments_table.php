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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
              

            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('complaint')->nullable(); 
            $table->string('consultation_room')->nullable(); 
            $table->enum('speciality', ['Endodontics', 'Pediatric Dentistry', 'Orthodontics', 'Periodontics' , 'Full Dental Exam','General Dental Care','Oral and Maxillofacial Surgery'])->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected','Done'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
