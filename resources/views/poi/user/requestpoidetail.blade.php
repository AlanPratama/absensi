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
                            <button onClick="return confirm('Are You Sure')" type="submit"
                                class="btn btn-primary btn-sm"><i class="fa-solid fa-hand mr-2"></i> Request POI
                                Ini</button>
                        </form>
                    @endif
                @else
                    @if ($poi->status != 'Done' || $poi->status != 'Cancel')
                        @if ($poi->status == 'Pending')
                            <form action="{{ url('/inbox-poi/change-status/' . $poi->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="In Progress">
                                <button onClick="return confirm('Are You Sure')" type="submit"
                                    class="btn btn-primary btn-sm"><i class="fa-solid fa-gear mr-2"></i> Sedang
                                    Dikerjakan</button>
                            </form>
                        @elseif ($poi->status == 'In Progress')
                            @push('style')
                                {{-- sign --}}
                                <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
                                <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
                                <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
                                <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
                                {{-- end sign --}}
                            @endpush
                            <div>
                                <input type="hidden" name="status" value="Done">
                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                                    data-original-title="POI Done" data-bs-target="#poi-done-modal"><i
                                        class="fa fa-table mr-2"></i>
                                    Sudah Diselesaikan</button>
                            </div>

                            <div class="modal fade" id="poi-done-modal" tabindex="-1" role="dialog"
                                aria-labelledby="poi-done-modalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="poi-done-modalLabel">POI Selesai</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ url('/inbox-poi/poi-detail/' . $poi->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @csrf
                                                <div class="form-group mb-4">
                                                    <label for="pesan">Pesan</label>
                                                    <input type="text" name="pesan" id="pesan"
                                                        class="form-control @error('pesan') is-invalid @enderror">
                                                    @error('pesan')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="foto">Unggah Foto</label>
                                                    <input type="file" accept="image/*" name="foto" id="foto"
                                                        class="form-control @error('foto') is-invalid @enderror">
                                                    @error('foto')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-4">
                                                    <label for="">Signature:</label>
                                                    <div>
                                                        <div class="rounded shadow-sm border @error('signed') is-invalid @enderror"
                                                            id="sig"></div>
                                                        <button id="clear" class="mt-2 btn btn-warning btn-sm">Clear
                                                            Signature</button>
                                                        <textarea id="signature64" name="signed" style="display: none"></textarea>
                                                    </div>
                                                    @error('signed')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" type="submit">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                var sig = $('#sig').signature({
                                    syncField: '#signature64',
                                    syncFormat: 'PNG'
                                });
                                $('#clear').click(function(e) {
                                    e.preventDefault();
                                    sig.signature('clear');
                                    $("#signature64").val('');
                                });
                            </script>
                        @endif
                    @endif
                @endif
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mt-7">Point Of Interest (POI)</h2>
                @if ($poi->status == 'Done' && $poi->DetailPOI)
                    @php
                        $detail_poi = $poi->DetailPOI;
                    @endphp
                    <div>
                        <button type="button" data-bs-toggle="modal" data-original-title="POI Done"
                            data-bs-target="#detail-poi-modal" class="btn btn-primary btn-sm mt-7">Detail POI</button>
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
                                        <span style="color:black; font-size:14px">{{ $detail_poi->pesan }}</span>
                                        <h2 class="mt-3 mb-1"><span class="fa-solid fa-image me-2"
                                                style="font-size: 20px; color:black"></span>Foto</h2>
                                        <img class="w-100 rounded shadow-sm"
                                            src="{{ url('/storage/' . $detail_poi->foto) }}"
                                            alt="{{ $detail_poi->pesan }}" class="shadow-sm rounded">
                                        <h2 class="mt-3 mb-1"><span class="fa-solid fa-file-signature me-2"
                                                style="font-size: 20px; color:black"></span>Tanda Tangan</h2>
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
                $tgl_mulai = new DateTime($poi->tanggal_mulai);
            @endphp
            <ul class="mt-2">
                <li class="mt-4"><span class="fa-solid fa-bullseye me-3" style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $poi->target }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Target</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
                <li class="mt-4"><span class="fa-solid fa-file me-3" style="font-size: 20px; color:black"></span> <span
                        style="color:black; font-size:14px">{{ $poi->tipe }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Tipe</span></li>
                <hr style="color: rgb(204, 204, 204)">
                @if ($poi->tipe == 'Kuantitas')
                    <li class="mt-4"><span class="fa fa-rupiah-sign me-3" style="font-size: 20px; color:black"></span>
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

                <li class="mt-4"><span class="fa-solid fa-file-lines me-3" style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $poi->KategoriPOI->kategori ?? '-' }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Kategori</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
                @if ($poi->status != 'Pending')
                    <li class="mt-4"><span class="fa-solid fa-circle-exclamation me-3"
                            style="font-size: 20px; color:black"></span>
                        <span
                            style="color:black; font-size:14px">{{ $poi->terlambat ? 'Terlambat' : 'Tidak Terlambat' }}</span>
                        <span style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                            Terlambat</span>
                    </li>
                    <hr style="color: rgb(204, 204, 204)">
                @endif
                <li class="mt-4"><span class="fa-solid fa-flag me-3" style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $poi->status }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Status</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
                <li class="mt-4"><span class="fa-solid fa-calendar-days me-3"
                        style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $tgl->format('d M Y') }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Tanggal
                        Dibuat</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
                <li class="mt-4"><span class="fa-solid fa-calendar-check me-3"
                        style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $tgl_mulai->format('d M Y') }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Tanggal
                        Mulai</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
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
                @if (is_numeric($poi->lat_poi) && is_numeric($poi->long_poi))
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
                <li class="mt-4"><span class="fa-solid fa-user-tie me-3" style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->nama }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Nama</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
                <li class="mt-4"><span class="fa fa-building me-3" style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->tipe }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Tipe</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
                <li class="mt-4"><span class="fa fa-map-marker me-3" style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->alamat }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Alamat</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
                <li class="mt-4"><span class="icon-phone me-3" style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->no_telepon }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Telepon</span>
                </li>
                <hr style="color: rgb(204, 204, 204)">
                <li class="mt-4"><span class="fa fa-user-secret me-3" style="font-size: 20px; color:black"></span>
                    <span style="color:black; font-size:14px">{{ $poi->Pelanggan->no_telepon_pic }}</span> <span
                        style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Telepon
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
                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Nama</span>
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
                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Email</span>
                    </li>
                    <hr style="color: rgb(204, 204, 204)">
                    <li class="mt-4"><span class="icon-phone me-3" style="font-size: 20px; color:black"></span>
                        <span style="color:black; font-size:14px">{{ $pegawai->telepon }}</span> <span
                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right">
                            Telepon</span>
                    </li>
                    <hr style="color: rgb(204, 204, 204)">
                    <li class="mt-4"><span class="fa-solid fa-venus-mars me-3"
                            style="font-size: 20px; color:black"></span>
                        <span style="color:black; font-size:14px">{{ $pegawai->gender }}</span> <span
                            style="font-style: italic; font-size:12px; color:rgb(139, 139, 139); float:right"> Jenis
                            Kelamin</span>
                    </li>
                    <hr style="color: rgb(204, 204, 204)">
                    {{-- {{ $tgl_lahir->format('d M Y') }} --}}
                </ul>
            @endif

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
