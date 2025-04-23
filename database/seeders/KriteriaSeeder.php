<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            ['kode_kriteria' => 'P1', 'tahun' => 2025, 'nama_kriteria' => 'Quality', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'P2', 'tahun' => 2025, 'nama_kriteria' => 'Quantity', 'atribut' => 'cost'],
            ['kode_kriteria' => 'P3', 'tahun' => 2025, 'nama_kriteria' => 'Cost Saving', 'atribut' => 'cost'],
            ['kode_kriteria' => 'P4', 'tahun' => 2025, 'nama_kriteria' => 'Layanan Rekanan', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'P5', 'tahun' => 2025, 'nama_kriteria' => 'Delivery', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'P6', 'tahun' => 2025, 'nama_kriteria' => 'Kepatuhan', 'atribut' => 'benefit'],
        ];

        foreach ($data as $item) {
            Kriteria::create($item);
        }
    }
}
