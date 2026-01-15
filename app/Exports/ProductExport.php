<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Support\Facades\DB;

class ProductExport implements FromCollection, WithHeadings
{
    protected $cid;
    protected $q;

    public function __construct($cid, $q)
    {
        $this->cid = $cid;
        $this->q = $q;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('units', 'products.unit_id', '=', 'units.id')
            ->select(
                'products.id',
                'products.code',
                'products.name',
                'products.kh_name',
                'products.price',
                'products.cost',
                'categories.name as category',
                'products.onhand',
                'products.alert',
                'products.begin_balance',
                'products.barcode'
            )
            ->where('products.active', 1);

        if ($this->cid !== 'all') {
            $query->where('products.category_id', $this->cid);
        }

        if (!empty($this->q)) {
            $query->where('products.name', 'like', '%' . $this->q . '%');
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Code', 'Name', 'Kh Name', 'Price', 'Cost', 'Category', 'Onhand', 'Alerts', 'Begin Balance', 'Barcode'
        ];
    }
}
