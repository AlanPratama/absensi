@extends('templates.dashboard')
@section('isi')
    @php
        $lat_kantor = $data_user->Lokasi->lat_kantor;
        $long_kantor = $data_user->Lokasi->long_kantor;
        $radius = $data_user->Lokasi->radius;
    @endphp
    @push('style')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
            integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush

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
                    <div class="repicient-content">
                        <div class="tf-container">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="mt-7">Point Of Interest (POI)</h2>
                                @if ($poi->status == 'Done' && $poi->DetailPOI)
                                    @php
                                        $detail_poi = $poi->DetailPOI;
                                    @endphp
                                    <div>
                                        <button type="button" data-bs-toggle="modal" data-original-title="POI Done"
                                            data-bs-target="#detail-poi-modal" class="btn btn-primary btn-sm mt-7">Detail
                                            POI</button>
                                    </div>

                                    <div class="modal fade" id="detail-poi-modal" tabindex="-1" role="dialog"
                                        aria-labelledby="detail-poi-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detail-poi-modalLabel">
                                                        {{ \Carbon\Carbon::parse($detail_poi->created_at)->locale('id_ID')->format('d M Y - H:i') }}
                                                        WIB</h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div>
                                                    <div class="modal-body">

                                                        <h2 class="mb-1"><span class="fa-solid fa-message me-2"
                                                                style="font-size: 20px; color:black"></span>Pesan</h2>
                                                        <span
                                                            style="color:black; font-size:14px">{{ $detail_poi->pesan }}</span>
                                                        <h2 class="mt-3 mb-1"><span class="fa-solid fa-image me-2"
                                                                style="font-size: 20px; color:black"></span>Foto</h2>
                                                        <img class="w-100 rounded shadow-sm"
                                                            src="{{ url('/storage/' . $detail_poi->foto) }}"
                                                            alt="{{ $detail_poi->pesan }}" class="shadow-sm rounded">
                                                        <h2 class="mt-3 mb-1"><span class="fa-solid fa-file-signature me-2"
                                                                style="font-size: 20px; color:black"></span>Tanda Tangan
                                                        </h2>
                                                        <img class="w-100 rounded shadow-sm"
                                                            src="{{ url('/storage/' . $detail_poi->tanda_tangan) }}"
                                                            alt="{{ $detail_poi->pesan }}" class="shadow-sm rounded">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button data-bs-dismiss="modal" class="btn btn-primary"
                                                            type="button">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @php
                                $tgl = new DateTime($poi->tanggal);
                                $tgl_mulai = $poi->tanggal_mulai ? new DateTime($poi->tanggal_mulai) : null;
                            @endphp
                            <ul class="mt-2">
                                <li class="mt-4"><span class="fa-solid fa-bullseye me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span style="color:black; font-size:14px">{{ $poi->target }}</span> <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Target</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                                <li class="mt-4"><span class="fa-solid fa-file me-3"
                                        style="font-size: 20px; color:black"></span> <span
                                        style="color:black; font-size:14px">{{ $poi->tipe }}</span> <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Tipe</span></li>
                                <hr style="color: rgb(204, 204, 204)">
                                @if ($poi->tipe == 'Kuantitas')
                                    <li class="mt-4"><span class="fa fa-rupiah-sign me-3"
                                            style="font-size: 20px; color:black"></span>
                                        <span
                                            style="color:black; font-size:14px">{{ 'Rp. ' . number_format($poi->jumlah_nominal, 0, ',', '.') }}</span>
                                        <span
                                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                            Jumlah
                                            Nominal</span>
                                    </li>
                                    <hr style="color: rgb(204, 204, 204)">
                                    {{-- <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span>
                                        <span style="color:black; font-size:14px">Rp. {{ $poi->jumlah_nominal_akhir ? number_format($poi->jumlah_nominal_akhir, 0, ',', '.') : '-' }}</span> <span
                                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> TEST</span>
                                    </li>
                                    <hr style="color: rgb(204, 204, 204)"> --}}
                                @endif

                                <li class="mt-4"><span class="fa-solid fa-file-lines me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span
                                        style="color:black; font-size:14px">{{ $poi->KategoriPOI->kategori ?? '-' }}</span>
                                    <span style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Kategori</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">

                                <li class="mt-4"><span class="fa-solid fa-flag me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span style="color:black; font-size:14px">{{ $poi->status }}</span> <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Status</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                                <li class="mt-4"><span class="fa-solid fa-calendar-days me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span style="color:black; font-size:14px">{{ $tgl->format('d M Y') }}</span> <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Tanggal
                                        Dibuat</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                                <li class="mt-4"><span class="fa-solid fa-calendar-check me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span
                                        style="color:black; font-size:14px">{{ $tgl_mulai ? $tgl_mulai->format('d M Y') : '-' }}</span>
                                    <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Deadline</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                            </ul>

                            <div>
                                @php
                                    $lat_kantor = $data_user->Lokasi->lat_kantor;
                                    $long_kantor = $data_user->Lokasi->long_kantor;
                                    $radius = $data_user->Lokasi->radius;
                                @endphp
                                @if ($poi->foto)
                                    <img src="{{ url('/storage/' . $poi->foto) }}" alt="{{ $poi->target }}"
                                        class="shadow-sm rounded">
                                @endif
                                @if (is_numeric($poi->lat_poi) && is_numeric($poi->long_poi))
                                    <div id="map"
                                        style="margin-top: 40px;border-radius:6px;width:100%;height:250px;z-index: 1;"></div>
                                    <h4 class="mt-3">{{ $poi->lat_poi }}, {{ $poi->long_poi }}</h4>
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

                            <h2 class="mt-7">Detail Pelanggan</h2>
                            <ul class="mt-2">
                                <li class="mt-4"><span class="fa-solid fa-user-tie me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->nama }}</span> <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Nama</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                                <li class="mt-4"><span class="fa fa-building me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->tipe }}</span> <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Tipe</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                                <li class="mt-4"><span class="fa fa-map-marker me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->alamat }}</span> <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Alamat</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                                <li class="mt-4"><span class="fa-solid fa-phone me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->no_telepon }}</span>
                                    <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Telepon</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                                <li class="mt-4"><span class="fa fa-user-secret me-3"
                                        style="font-size: 20px; color:black"></span>
                                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->no_telepon_pic }}</span>
                                    <span
                                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                        Telepon
                                        PIC</span>
                                </li>
                                <hr style="color: rgb(204, 204, 204)">
                                {{-- {{ $tgl_lahir->format('d M Y') }} --}}
                            </ul>

                            @if ($poi->Pegawai)
                                @php
                                    $pegawai = $poi->Pegawai;
                                @endphp
                                <h2 class="mt-7">Detail Pegawai</h2>
                                <ul class="mt-2">
                                    <li class="mt-4"><span class="fa-solid fa-user-gear me-3"
                                            style="font-size: 20px; color:black"></span>
                                        <span style="color:black; font-size:14px">{{ $pegawai->name }}</span> <span
                                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                            Nama</span>
                                    </li>
                                    <hr style="color: rgb(204, 204, 204)">
                                    <li class="mt-4"><span class="fa-solid fa-address-card me-3"
                                            style="font-size: 20px; color:black"></span>
                                        <span style="color:black; font-size:14px">{{ $pegawai->username }}</span> <span
                                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                            Username</span>
                                    </li>
                                    <hr style="color: rgb(204, 204, 204)">
                                    <li class="mt-4"><span class="fa-solid fa-envelope me-3"
                                            style="font-size: 20px; color:black"></span>
                                        <span style="color:black; font-size:14px">{{ $pegawai->email }}</span> <span
                                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                            Email</span>
                                    </li>
                                    <hr style="color: rgb(204, 204, 204)">
                                    <li class="mt-4"><span class="icon-phone me-3"
                                            style="font-size: 20px; color:black"></span>
                                        <span style="color:black; font-size:14px">{{ $pegawai->telepon }}</span> <span
                                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                            Telepon</span>
                                    </li>
                                    <hr style="color: rgb(204, 204, 204)">
                                    <li class="mt-4"><span class="fa-solid fa-venus-mars me-3"
                                            style="font-size: 20px; color:black"></span>
                                        <span style="color:black; font-size:14px">{{ $pegawai->gender }}</span> <span
                                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                                            Jenis
                                            Kelamin</span>
                                    </li>
                                    <hr style="color: rgb(204, 204, 204)">
                                    {{-- {{ $tgl_lahir->format('d M Y') }} --}}
                                </ul>
                            @endif

                        </div>

                    </div>
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
