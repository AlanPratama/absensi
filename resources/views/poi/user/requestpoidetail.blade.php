@extends('templates.app')
@section('container')
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="tf-spacing-16"></div>

                <div class="bill-content">
                    <div>
                        <div class="mb-1 d-flex justify-content-between">
                            <h5>Point Of Interest</h5>
                            <div class="d-flex align-items-center gap-2">
                                @if ($poi->status != 'Pending' && $poi->terlambat)
                                    <h5 class="badge bg-danger">Terlambat</h5>
                                @endif

                                @if ($poi->status == 'Pending')
                                    <h5 class="badge bg-info">{{ $poi->status }}</h5>
                                @elseif($poi->status == 'In Progress')
                                    <h5 class="badge bg-warning">{{ $poi->status }}</h5>
                                @elseif($poi->status == 'Done')
                                    <h5 class="badge bg-success">{{ $poi->status }}</h5>
                                @else
                                    <h5 class="badge bg-danger">{{ $poi->status }}</h5>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <h3>{{ $poi->target }}</h3>
                        </div>
                    </div>
                </div>
                <div class="tf-spacing-16"></div>
            </div>
        </div>
    </div>
    <div class="transfer-content"></div>
    <div class="repicient-content">
        <div class="tf-container">
            <div class="d-flex align-items-center mt-7">

                @if ($poi->pegawai_id == null)
                    @if (!$sudahRequest)
                        <form action="{{ url('/request-poi/process/' . $poi->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <button type="submit" class="btn btn-primary">Request POI Ini</button>
                        </form>
                    @endif
                @else
                    @if ($poi->status != 'Done' || $poi->status != 'Cancel')
                        <form action="{{ url('/inbox-poi/change-status/' . $poi->id) }}" method="post">
                            @csrf
                            @method('patch')
                            @if ($poi->status == 'Pending')
                                <input type="hidden" name="status" value="In Progress">
                                <button onClick="return confirm('Are You Sure')" type="submit" class="btn btn-primary">Sedang Dikerjakan</button>
                            @elseif ($poi->status == 'In Progress')
                                {{-- INI NANTI DIGANTI JADI MODAL, SOALNYA PERLU INPUT POI DETAIL --}}
                                <input type="hidden" name="status" value="Done">
                                {{-- INI NANTI DIGANTI JADI MODAL, SOALNYA PERLU INPUT POI DETAIL --}}
                                <button type="submit" class="btn btn-success">Sudah Diselesaikan</button>
                                {{-- INI NANTI DIGANTI JADI MODAL, SOALNYA PERLU INPUT POI DETAIL --}}
                            @endif
                        </form>
                    @endif
                @endif
            </div>
            <h2 class="mt-7">Detail POI (Point Of Interest)</h2>
            @php
                $tgl = new DateTime($poi->tanggal);
                $tgl_mulai = new DateTime($poi->tanggal_mulai);
            @endphp
            <ul class="mt-2">
                {{-- <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $poi->target }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Test</span></li>
                <hr style="color: rgb(204, 204, 204)"> --}}

                <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $poi->tipe }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Tipe</span></li>
                <hr style="color: rgb(204, 204, 204)">
                @if ($poi->tipe == 'Kuantitas')
                    <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span>
                        <span
                            style="color:black; font-size:14px">{{ 'Rp. ' . number_format($poi->jumlah_nominal, 0, ',', '.') }}</span>
                        <span style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Jumlah
                            Nominal</span>
                    </li>
                    <hr style="color: rgb(204, 204, 204)">
                    {{-- <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span>
                        <span style="color:black; font-size:14px">Rp. {{ $poi->jumlah_nominal_akhir ? number_format($poi->jumlah_nominal_akhir, 0, ',', '.') : '-' }}</span> <span
                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> TEST</span>
                    </li>
                    <hr style="color: rgb(204, 204, 204)"> --}}
                @endif

                <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $poi->KategoriPOI->kategori ?? '-' }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Kategori</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">

                <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $poi->status }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Status</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">

                <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $tgl->format('d M Y') }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Tanggal
                        Dibuat</span></li>
                <hr style="color: rgb(204, 204, 204)">
                <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $tgl_mulai->format('d M Y') }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Tanggal
                        Mulai</span></li>
                <hr style="color: rgb(204, 204, 204)">

                {{-- <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $poi->Pelanggan->no_telepon_pic }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Telepon</span></li>
                <hr style="color: rgb(204, 204, 204)"> --}}

                {{-- {{ $tgl_lahir->format('d M Y') }} --}}
            </ul>

            <div>
                @php
                    $lat_kantor = $data_user->Lokasi->lat_kantor;
                    $long_kantor = $data_user->Lokasi->long_kantor;
                    $radius = $data_user->Lokasi->radius;
                @endphp
                @if ($poi->foto)
                    <img src="{{ url('/storage/' . $poi->foto) }}" alt="{{ $poi->target }}" class="shadow-sm rounded">
                @endif
                @if ($poi->lat_poi && $poi->long_poi)
                    <div id="map" style="margin-top: 40px;border-radius:6px;width:100%;height:250px;"></div>
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
                <li class="list-user-info"><span class="icon-user"></span>{{ $poi->Pelanggan->nama }}</li>
                <li class="list-user-info"><span class="fa fa-building"></span>{{ $poi->Pelanggan->tipe }}</li>
                <li class="list-user-info"><span class="fa fa-map-marker"></span>{{ $poi->Pelanggan->alamat }}</li>
                <li class="list-user-info"><span class="icon-phone"></span>{{ $poi->Pelanggan->no_telepon }}</li>
                <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $poi->Pelanggan->no_telepon_pic }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Test</span></li>
                <hr style="color: rgb(204, 204, 204)">
                {{-- {{ $tgl_lahir->format('d M Y') }} --}}
            </ul>
        </div>

    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
@endsection
