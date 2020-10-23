<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection
{
    protected $collection;
    protected $header;

    function __construct($collection, $header)
    {
        $this->collection = $collection;
        $this->header = $header;
    }

    public function collection()
    {
        /* Prepending set headers to the collection */
        $this->collection->prepend($this->header);
        return new Collection($this->collection);
    }
}