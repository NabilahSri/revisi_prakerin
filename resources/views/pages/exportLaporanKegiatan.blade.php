@php
    use App\Models\Kegiatan;
    use Carbon\Carbon;

    Carbon::setLocale('id');
@endphp
    <div class="col">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%">
                        @if (auth()->user()->level == 'admin')
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Total Jam Kerja</th>
                                    <th style="width: 100px">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($kegiatan as $key => $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $item->siswa->name }}</td>
                                            <td>{{ $item->total_durasi }}</td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        @else
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @php
                                        $groupedKegiatan = $kegiatan->groupBy(function($item) {
                                            return Carbon::parse($item->kehadiran->tanggal)->translatedFormat('l, d-m-Y');
                                        });
                                    @endphp
                                    @foreach ($groupedKegiatan as $tanggal => $items)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tanggal }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($items as $item)
                                                        <li>{{ $item->deskripsi }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
