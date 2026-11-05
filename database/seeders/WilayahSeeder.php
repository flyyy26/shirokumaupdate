<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('villages')->truncate();
        DB::table('districts')->truncate();
        DB::table('regencies')->truncate();
        DB::table('provinces')->truncate();

        $this->import('provinces', 2);
        $this->import('regencies', 3);
        $this->import('districts', 3);
        $this->import('villages', 3);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function import($table, $columnCount)
    {
        $path = database_path("data/{$table}.csv");

        if (!file_exists($path)) {
            echo "File {$table}.csv tidak ditemukan\n";
            return;
        }

        $file = fopen($path, 'r');

        // Detect delimiter (tab atau koma)
        $firstLine = fgets($file);
        rewind($file);

        $delimiter = str_contains($firstLine, "\t") ? "\t" : ",";

        $data = [];

        while (($row = fgetcsv($file, 0, $delimiter)) !== false) {

            // skip baris kosong
            if (count($row) < $columnCount) continue;

            // skip jika bukan angka di kolom pertama
            if (!is_numeric(trim($row[0]))) continue;

            if ($table == 'provinces') {
                $data[] = [
                    'id' => (int) trim($row[0]),
                    'name' => trim($row[1]),
                ];
            }

            if ($table == 'regencies') {
                $data[] = [
                    'id' => (int) trim($row[0]),
                    'province_id' => (int) trim($row[1]),
                    'name' => trim($row[2]),
                ];
            }

            if ($table == 'districts') {
                $data[] = [
                    'id' => (int) trim($row[0]),
                    'regency_id' => (int) trim($row[1]),
                    'name' => trim($row[2]),
                ];
            }

            if ($table == 'villages') {
                $data[] = [
                    'id' => (int) trim($row[0]),
                    'district_id' => (int) trim($row[1]),
                    'name' => trim($row[2]),
                ];
            }

            if (count($data) == 1000) {
                DB::table($table)->insertOrIgnore($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table($table)->insertOrIgnore($data);
        }

        fclose($file);

        echo "Import {$table} selesai\n";
    }
}