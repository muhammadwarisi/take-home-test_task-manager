<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            [
                'title' => 'Membuat laporan bulanan',
                'description' => 'Menyusun dan mengirimkan laporan bulanan ke manajer.',
                'status' => 'Belum Selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Meeting dengan klien',
                'description' => 'Menghadiri meeting dengan klien untuk membahas proyek baru.',
                'status' => 'Selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Review kode',
                'description' => 'Melakukan review kode untuk tim pengembang.',
                'status' => 'Selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
