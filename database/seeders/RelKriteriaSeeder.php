<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $kriteria = ['P1', 'P2', 'P3', 'P4', 'P5', 'P6'];
        $data = [];

        foreach ($kriteria as $id1) {
            foreach ($kriteria as $id2) {
                $data[] = [
                    'tahun' => 2025,
                    'ID1' => $id1,
                    'ID2' => $id2,
                    'nilai' => ($id1 === $id2) ? 1 : 1, // default 1, bisa kamu ubah nanti kalau pakai input manual
                ];
            }
        }
        DB::table('rel_kriteria')->insert($data);
    }
}
