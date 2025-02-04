<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('id_user')->nullable(); // Foreign key ke tabel users
            $table->string('panggilan')->nullable(); // Nama panggilan
            $table->string('nim')->nullable(); // NIM
            $table->string('nik')->nullable(); // NIK
            $table->string('institusi');  // asal instansi
            $table->string('program_studi');  // program studi
            $table->string('medsos')->nullable(); // Media sosial
            $table->string('nomor_hp')->nullable(); // Nomor hp
            $table->string('jenis_kelamin')->nullable(); // Nomor hp
            $table->string('agama')->nullable(); // Nomor hp
            $table->string('alamat')->nullable(); // Nomor hp
            $table->string('domisili')->nullable(); // Nomor hp
            $table->string('status_pendaftaran')->default('default'); // Nomor hp
            $table->string('foto')->nullable(); // Path ke foto
            $table->timestamps(); 

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); // Tambahkan foreign key
        });
    }

    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropForeign(['id_user']); // Hapus foreign key
            $table->dropColumn(['id_user', 'panggilan', 'nim', 'nik', 'medsos', 'foto']); // Hapus kolom
        });
    }
};
