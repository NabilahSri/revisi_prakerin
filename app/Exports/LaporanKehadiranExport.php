<?php

namespace App\Exports;

use App\Models\Kehadiran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanKehadiranExport implements FromView
{
    protected $data;

    public function __construct($data){
        return $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('pages.exportLaporanKehadiran',['kehadiran' => $this->data]);
    }
}
