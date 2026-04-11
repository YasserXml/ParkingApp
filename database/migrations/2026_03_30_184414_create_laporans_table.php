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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->enum('jenis_laporan', ['harian', 'mingguan', 'bulanan', 'custom'])->default('harian');
            $table->date('periode_dari');
            $table->date('periode_sampai');
            $table->foreignId('area_id')->nullable()->constrained('area_parkirs')->nullOnDelete();
            $table->unsignedInteger('total_transaksi')->default(0);
            $table->unsignedInteger('total_kendaraan_masuk')->default(0);
            $table->unsignedInteger('total_kendaraan_keluar')->default(0);
            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->decimal('rata_rata_durasi_menit', 8, 2)->default(0);
            $table->json('ringkasan_per_jenis')->nullable();
            $table->json('ringkasan_per_area')->nullable();
            $table->timestamp('generated_at')->useCurrent();
            $table->string('generated_by')->nullable();
            $table->timestamps();
            $table->index(['jenis_laporan', 'periode_dari', 'periode_sampai'], 'idx_laporan_periode');
            $table->index('area_id');
            $table->index('generated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
