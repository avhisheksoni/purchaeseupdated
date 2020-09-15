<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use App\item;

class ItemsExcelExport implements FromQuery, WithHeadings ,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /*public function collection()
    {
        return item::all();
    }*/

    public function query()
    {
    		$data = item::with(['brand_name','department_name','category','unit']);
    		return $data;
    }
    public function map($item): array
    {
    	return [ 
    		$item->title,
    		$item['category']->name,
    		$item['brand_name']->name,
    		$item['department_name']->name,
    		$item['unit']->name,
    		$item->description
      ];
    }
    public function headings(): array
    {
        return ['Titles','Category Name','Subcategory Name','Department','Units','Descriptions'];
    }
}
