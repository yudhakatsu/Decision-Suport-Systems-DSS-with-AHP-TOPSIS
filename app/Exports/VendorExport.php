<?php

namespace App\Exports;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VendorExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $vendors = Vendor::all();

        return $vendors->map(function ($vendor, $index) {
            return [
                'No' => $index + 1,
                'Vendor' => $vendor->username,
                'Peringkat' => $vendor->peringkat ?? '-', // Sesuaikan
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Vendor',
            'Peringkat',
        ];
    }
}
