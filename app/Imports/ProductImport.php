<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;

class ProductImport implements ToCollection
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Skip header row (assuming first row is headers)
        $rows->shift();

        foreach ($rows as $row) {
            DB::table('products')->insert([
                'code'        => $row[1],  // Adjust index to match your columns
                'name'        => $row[2],
                'price'       => $row[3],
                'category_id' => $this->getCategoryId($row[4]), // get ID by category name
                'active'      => 1,
                // Add other fields as needed
            ]);
        }
    }

    /**
     * Helper to get category ID by category name
     */
    private function getCategoryId($categoryName)
    {
        return DB::table('categories')->where('name', $categoryName)->value('id') ?? null;
    }
}
