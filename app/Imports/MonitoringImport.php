<?php

namespace App\Imports;

use App\Models\Monitoring;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MonitoringImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Monitoring([
            'id_pemonitor' => $row['id_pemonitor'],
            'id_industri' => $row['id_industri'],
            'id_siswa' => $row['id_siswa'],
        ]);
    }
}
