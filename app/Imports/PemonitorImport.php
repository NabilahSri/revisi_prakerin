<?php

namespace App\Imports;

use App\Models\Pemonitor;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PemonitorImport implements ToModel, WithHeadingRow
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
            'level' => 'pemonitor',
        ]);
        return new Pemonitor([
            'nip' => $row['nip'],
            'name' => $row['name'],
            'email'=> $row['email'],
            'telp'=> $row['telp'],
            'alamat'=> $row['alamat'],
            'id_user' => $user->id,
        ]);
    }
}
