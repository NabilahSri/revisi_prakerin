<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Industri;
use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Monitoring;
use App\Models\Pemonitor;
use App\Models\Pesan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Kelas::create([
            'kelas' => 'XII PPLG 2'
        ]);

        Kelas::create([
            'kelas' => 'XII PPLG 1'
        ]);

        User::create([
            'username' => 'adminTest',
            'password' => bcrypt('12341234'),
            'level'=> 'admin'
        ]);

        User::create([
            'username' => 'pemonitorTest',
            'password' => bcrypt('12341234'),
            'level'=> 'pemonitor'
        ]);

        User::create([
            'username' => 'siswaTest',
            'password' => bcrypt('12341234'),
            'level'=> 'siswa'
        ]);

        User::create([
            'username' => 'industriTest',
            'password' => bcrypt('12341234'),
            'level'=> 'industri'
        ]);

        User::create([
            'username' => 'siswaTest2',
            'password' => bcrypt('12341234'),
            'level'=> 'siswa'
        ]);

        Pemonitor::create([
            'nip' => '123456789',
            'name' => 'Imam Amirulloh',
            'email'=> 'billb4721@gmail.com',
            'telp'=> '085861783385',
            'alamat'=> 'Tasikmalaya',
            'id_user'=> 2
        ]);

        Siswa::create([
            'nisn' => '0065123456789',
            'name' => 'Nabilah Sri Mulyani',
            'email'=> 'billb4721@gmail.com',
            'telp'=> '085861783384',
            'lat' => '-7.354552198325482',
            'long' => '108.10618064478258',
            'alamat'=> 'Tasikmalaya',
            'kunci_lokasi' => 0,
            'id_user'=> 3,
            'id_kelas'=> 1
        ]);

        Siswa::create([
            'nisn' => '0065189456789',
            'name' => 'hhhhh',
            'email'=> 'willy.nabilah62@gmail.com',
            'telp'=> '085861783384',
            'lat' => '-7.354552198325482',
            'long' => '108.10618064478258',
            'alamat'=> 'Tasikmalaya',
            'kunci_lokasi' => 1,
            'id_user'=> 5,
            'id_kelas'=> 2
        ]);

        Industri::create([
            'name' => 'SMK YPC Tasikmalaya',
            'ceo' => 'Drs. Ujang Sanusi MM',
            'email' => 'ypc@gmail.com',
            'alamat' => 'Tasikmalaya',
            'telp' => '085861783386',
            'id_user' => 4,
        ]);

        Monitoring::create([
            'id_pemonitor' => 1,
            'id_industri' => 1,
            'id_siswa' => 1,
        ]);

        Monitoring::create([
            'id_pemonitor' => 1,
            'id_industri' => 1,
            'id_siswa' => 2,
        ]);

        Kehadiran::create([
            'tanggal' => '2024-08-28',
            'jam_masuk' => '15:20:16',
            'status' => 'hadir',
            'id_siswa' => 1,
            'id_user' => 1,
        ]);

        Kehadiran::create([
            'tanggal' => '2024-08-28',
            'jam_masuk' => '15:20:16',
            'status' => 'hadir',
            'id_siswa' => 2,
            'id_user' => 1,
        ]);

        Kegiatan::create([
            'deskripsi' => 'iiiii',
            'durasi' => '90',
            'id_kehadiran' => 1,
            'id_siswa' => 1,
            'id_kelas' => 1,
        ]);

        Kegiatan::create([
            'deskripsi' => '00000',
            'durasi' => '90',
            'id_kehadiran' => 1,
            'id_siswa' => 1,
            'id_kelas' => 1,
        ]);

        Kegiatan::create([
            'deskripsi' => 'ioioioo',
            'durasi' => '90',
            'id_kehadiran' => 2,
            'id_siswa' => 2,
            'id_kelas' => 1,
        ]);

        Pesan::create([
            'id_pengirim' => 1,
            'id_penerima' => 3,
            'pesan' => 'absen kebanyakan kosong',
            'tanggal_kirim' => '2024-09-18 12:00:00'
        ]);

        Pesan::create([
            'id_pengirim' => 3,
            'id_penerima' => 1,
            'pesan' => 'mohon maaf bu saya sedang sakit',
            'tanggal_kirim' => '2024-09-18 13:00:00'
        ]);

    }
}
