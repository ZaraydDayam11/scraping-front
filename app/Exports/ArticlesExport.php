<?php

namespace App\Exports;

use App\Models\Article;
use App\Models\TableSetting;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArticlesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TableSetting::all();
    }
}
