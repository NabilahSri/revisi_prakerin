<?php

namespace App\Exports;

use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

Carbon::setLocale('id');

class LaporanKegiatanExport implements FromView
{
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('pages.exportLaporanKegiatan',['kegiatan' => $this->data]);
    }
}
