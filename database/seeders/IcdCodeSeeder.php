<?php

namespace Database\Seeders;

use Maatwebsite\Excel\Facades\Excel;
use League\Csv\Statement;
use League\Csv\Reader;
use App\Models\IcdCode;
use Illuminate\Database\Seeder;
use Spatie\SimpleExcel\SimpleExcelReader;
use Maatwebsite\Excel\Concerns\ToArray;

class IcdCodeSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('data/data_icd.xlsx');

        // Baca isi Excel, ambil sheet pertama
        $rows = Excel::toArray(new class implements ToArray {
            public function array(array $array)
            {
                return $array;
            }
        }, $filePath)[0];

        foreach ($rows as $index => $row) {
            if ($index === 0)
                continue; // skip header

            try {
                IcdCode::updateOrCreate(
                    ['code' => trim($row[0])], // Kolom pertama = kode
                    [
                        'description' => $row[1] ?? null, // Kolom kedua = deskripsi
                        'nf_excl' => $row[2] ?? null, // Kolom ketiga = nf_excl (opsional)
                    ]
                );

                echo "✅ INSERTED/UPDATED code={$row[0]}\n";
            } catch (\Exception $e) {
                echo "🔥 ERROR at row #{$index}: {$e->getMessage()}\n";
            }
        }

        echo "Seeder selesai 🚀\n";
    }
}
