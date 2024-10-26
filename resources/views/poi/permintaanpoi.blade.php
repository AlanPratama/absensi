@extends('templates.dashboard')
@section('isi')
    @php
        $lat_kantor = $data_user->Lokasi->lat_kantor;
        $long_kantor = $data_user->Lokasi->long_kantor;
        $radius = $data_user->Lokasi->radius;
    @endphp

    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 mt-2 p-0 d-flex">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <a href="{{ url('/data-poi') }}" class="btn btn-danger btn-sm ms-2">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detail POI</h4>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        @if ($poi->foto)
                            <div>
                                <img src="{{ asset('storage/' . $poi->foto) }}" class="shadow-sm rounded"
                                    style="width: 250px" alt="{{ $poi->target }}">
                            </div>
                        @endif
                        <div>
                            <h6>Target: {{ $poi->target }}</h6>
                            <h6>Tipe: {{ $poi->tipe }}</h6>
                            @if ($poi->tipe == 'Kuantitas')
                                <h6>Jumlah Nominal: {{ $poi->jumlah_nominal >= 0 ? $poi->jumlah_nominal : '-' }}</h6>
                                <h6>Jumlah Nominal Akhir:
                                    {{ $poi->jumlah_nominal_akhir != null && $poi->jumlah_nominal_akhir >= 0 ? $poi->jumlah_nominal_akhir : '-' }}
                                </h6>
                            @endif
                            <h6>Lat: {{ $poi->target }}</h6>
                            <h6>Long: {{ $poi->target }}</h6>
                            <h6>Status: {{ $poi->status }}</h6>
                        </div>
                    </div>

                    <h4 class="mt-3">Detail Pelanggan</h4>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div>
                            <h6>Nama: {{ $poi->Pelanggan->nama }}</h6>
                            <h6>No Telepon: {{ $poi->Pelanggan->no_telepon }}</h6>
                            <h6>No Telepon PIC: {{ $poi->Pelanggan->no_telepon_pic }}</h6>
                            <h6>Alamat: {{ $poi->Pelanggan->alamat }}</h6>
                            <h6>Tipe: {{ $poi->Pelanggan->tipe }}</h6>
                        </div>
                    </div>

                    @if ($poi->lat_poi && $poi->long_poi)
                    <h4 class="mt-3">{{ $poi->lat_poi }}, {{ $poi->long_poi }}</h4>
                        <div id="map" style="border-radius:6px;width:100%;height:400px;"></div>
                        <script>
                            var map = L.map('map').setView([{{ $poi->lat_poi }}, {{ $poi->long_poi }}], 18);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19,
                                attribution: '© OpenStreetMap'
                            }).addTo(map);
                            var marker = L.marker([{{ $poi->lat_poi }}, {{ $poi->long_poi }}]).addTo(map);
                            var circle = L.circle([{{ $lat_kantor }}, {{ $long_kantor }}], {
                                color: 'red',
                                fillColor: '#f03',
                                fillOpacity: 0.5,
                                radius: {{ $radius }}
                            }).addTo(map);

                            marker.bindPopup("<b>Lokasi POI</b>").openPopup();
                            circle.bindPopup("<b>Radius {{ $data_user->Lokasi->nama_lokasi ?? '' }}</b>");
                        </script>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pegawai</th>
                                    <th>Tanggal</th>
                                    {{-- <th>Target</th> --}}
                                    {{-- <th>Foto</th> --}}
                                    {{-- <th>Kategori</th> --}}
                                    {{-- <th>Tipe</th> --}}
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($poi->PermintaanPOI as $pPoi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pPoi->Pegawai ? $pPoi->Pegawai->name : '-' }}</td>
                                        <td>{{ $pPoi->tanggal }}</td>
                                        <td>
                                            @if ($pPoi->status == 'Pending')
                                                <span class="badge badge-info">{{ $pPoi->status }}</span>
                                            @elseif($pPoi->status == 'In Progress')
                                                <span class="badge badge-warning">{{ $pPoi->status }}</span>
                                            @elseif($pPoi->status == 'Done')
                                                <span class="badge badge-success">{{ $pPoi->status }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $pPoi->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="action">
                                                @if ($pPoi->status == 'Pending')
                                                    <li>
                                                        <form action="{{ url('/data-poi/permintaan/' . $pPoi->id) }}"
                                                            method="post" class="d-inline">
                                                            @method('patch')
                                                            @csrf
                                                            <input type="hidden" name="status" value="Diterima">
                                                            <input type="hidden" name="pegawai_id"
                                                                value="{{ $pPoi->pegawai_id }}">
                                                            <button class="border-0" style="background-color: transparent"
                                                                onClick="return confirm('Are You Sure')">
                                                                <span class="badge badge-success">Terima</span>
                                                            </button>
                                                        </form>
                                                    </li>

                                                    <li>
                                                        <form action="{{ url('/data-poi/permintaan/' . $pPoi->id) }}"
                                                            method="post" class="d-inline">
                                                            @method('patch')
                                                            @csrf
                                                            <input type="hidden" name="status" value="Ditolak">
                                                            <button class="border-0" style="background-color: transparent"
                                                                onClick="return confirm('Are You Sure')">
                                                                <span class="badge badge-danger">Tolak</span>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li>
                                                        <span
                                                            class="badge @if ($pPoi->status == 'Diterima') badge-success @else badge-danger @endif">Sudah
                                                            {{ $pPoi->status }}</span>
                                                    </li>
                                                    <li>
                                                        <form action="{{ url('/data-poi/permintaan/' . $pPoi->id) }}"
                                                            method="post" class="d-inline">
                                                            @method('patch')
                                                            @csrf
                                                            <input type="hidden" name="status" value="Pending">
                                                            <button class="border-0" style="background-color: transparent"
                                                                onClick="return confirm('Are You Sure')">
                                                                <span class="badge badge-info">Pending</span>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="d-flex justify-content-end mr-4">
                        {{ $data_poi->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function() {
                $('#mulai').change(function() {
                    var mulai = $(this).val();
                    $('#akhir').val(mulai);
                });
            });
        </script>
    @endpush
@endsection
