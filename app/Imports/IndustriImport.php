<?php

namespace App\Imports;

use App\Models\Industri;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndustriImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = User::create([
            'username' => $row['username'],
            'password' => bcrypt($row['password']),
            'level' => 'industri',
        ]);
        return new Industri([
            'name' => $row['name'],
            'ceo' => $row['pimpinan'],
            'email'=> $row['email'],
            'telp'=> $row['telp'],
            'alamat'=> $row['alamat'],
            'id_user' => $user->id,
            'lat' => $row['lat'],
            'long' => $row['long'],
        ]);
    }
}
