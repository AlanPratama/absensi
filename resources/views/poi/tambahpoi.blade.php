@extends('templates.dashboard')
@section('isi')
    {{-- @push('style')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
            integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
            crossorigin="" />
        <style>
            #mapid {
                min-height: 500px;
            }
        </style>
    @endpush --}}
    @push('script')
        {{-- <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script> --}}

        <script>
            jQuery.fn.ForceNumericOnly =
                function() {
                    return this.each(function() {
                        $(this).keydown(function(e) {
                            var key = e.charCode || e.keyCode || 0;
                            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers, hyphen ONLY
                            // home, end, period, and numpad decimal
                            return (
                                key == 189 ||
                                key == 8 ||
                                key == 9 ||
                                key == 13 ||
                                key == 46 ||
                                key == 110 ||
                                key == 190 ||
                                (key >= 35 && key <= 40) ||
                                (key >= 48 && key <= 57) ||
                                (key >= 96 && key <= 105));
                        });
                    });
                };

            var mapCenter = [
                {{ -6.2208658525024605 }},
                {{ 106.87877079945511 }},
            ];
            var map = L.map('mapid').setView(mapCenter, {{ 80 }});
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            var marker = L.marker(mapCenter).addTo(map);

            function updateMarker(lat, lng) {
                marker
                    .setLatLng([lat, lng])
                    .bindPopup("Lokasi POI: " + marker.getLatLng().toString())
                    .openPopup();
                return false;
            };
            map.on('click', function(e) {
                let latitude = e.latlng.lat.toString().substring(0, 15);
                let longitude = e.latlng.lng.toString().substring(0, 15);
                $('#lat_poi').val(latitude);
                $('#long_poi').val(longitude);
                updateMarker(latitude, longitude);
            });
            var updateMarkerByInputs = function() {
                return updateMarker($('#lat_poi').val(), $('#long_poi').val());
            }
            $('#lat_poi').on('input', updateMarkerByInputs);
            $('#long_poi').on('input', updateMarkerByInputs);

            $("#lat_poi").ForceNumericOnly();
            $("#long_poi").ForceNumericOnly();

            $('#buka_map').on('click', function() {
                $('#mapid').toggleClass('d-none');
                $('#buka_map').text($('#mapid').hasClass('d-none') ? 'Buka Map' : 'Tutup Map');
            })
        </script>
    @endpush

    <div class="row">
        <div class="col-md-12 m project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 p-0 d-flex mt-2">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <a href="{{ url('/data-poi') }}" class="btn btn-danger btn-sm ms-2">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <form method="post" action="{{ url('/data-poi/proses-tambah') }}" enctype="multipart/form-data"
                    class="p-4">
                    @csrf
                    <div class="form-row">
                        <div class="col mb-4">
                            <label for="pegawai_id">Nama Pegawai (opsional)</label>
                            <select id="pegawai_id" name="pegawai_id" class="form-control selectpicker" id="">
                                <option value="">Pilih Pegawai</option>
                                @foreach ($data_pegawai as $pegawai)
                                    @if (old('pegawai_id') == $pegawai->id)
                                        <option value="{{ $pegawai->id }}" selected>{{ $pegawai->name }}</option>
                                    @else
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('pegawai_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4">
                            <label for="pelanggan_id">Nama Pelanggan</label>
                            <select id="pelanggan_id" name="pelanggan_id" class="form-control selectpicker" id="">
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($data_pelanggan as $pelanggan)
                                    @if (old('pelanggan_id') == $pelanggan->id)
                                        <option value="{{ $pelanggan->id }}" selected>{{ $pelanggan->nama }}</option>
                                    @else
                                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('pelanggan_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4">
                            <label for="kategori_poi_id">Kategori POI</label>
                            <select id="kategori_poi_id" name="kategori_poi_id" class="form-control selectpicker"
                                id="">
                                <option value="">Pilih Kategori POI</option>
                                @foreach ($data_kategori_poi as $kategori_poi)
                                    @if (old('kategori_poi_id') == $kategori_poi->id)
                                        <option value="{{ $kategori_poi->id }}" selected>{{ $kategori_poi->kategori }}
                                        </option>
                                    @else
                                        <option value="{{ $kategori_poi->id }}">{{ $kategori_poi->kategori }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('kategori_poi_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4">
                            <label for="target">Target POI</label>
                            <input type="text" class="form-control @error('target') is-invalid @enderror" id="target"
                                name="target" value="{{ old('target') }}">
                            @error('target')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4">
                            <label for="tipe">Tipe POI</label>
                            <select id="tipe" name="tipe" class="form-control selectpicker" id="tipe">
                                <option value="">Pilih Tipe POI</option>
                                <option @if (old('tipe') == 'Kuantitas') selected @endif value="Kuantitas">Kuantitas
                                </option>
                                <option @if (old('tipe') == 'Deskriptif') selected @endif value="Deskriptif">Deskriptif
                                </option>
                            </select>
                            @error('tipe')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4 d-none" id="jumlah_nominal_div">
                            <label for="jumlah_nominal">Jumlah Nominal</label>
                            <input type="text" class="form-control money @error('jumlah_nominal') is-invalid @enderror"
                                id="jumlah_nominal" name="jumlah_nominal" value="{{ old('jumlah_nominal') }}">
                            @error('jumlah_nominal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4">
                            <label for="lat_poi">Lat POI (opsional)</label>
                            <input type="decimal" class="form-control numeric @error('lat_poi') is-invalid @enderror"
                                id="lat_poi" name="lat_poi" value="{{ old('lat_poi') }}">
                            @error('lat_poi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4">
                            <label for="long_poi">Long POI (opsional)</label>
                            <input type="decimal" class="form-control numeric @error('long_poi') is-invalid @enderror"
                                id="long_poi" name="long_poi" value="{{ old('long_poi') }}">
                            @error('long_poi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="container rounded shadow-sm w-100 mb-4" style="height: 500px; z-index: 0"
                            id="mapid"></div>
                        <div class="col mb-4">
                            <button type="button" id="buka_map" class="btn form-control btn-primary">Tutup Map</button>
                        </div>

                        <div class="col mb-4">
                            <label for="tanggal_mulai">Deadline (opsional)</label>
                            <input type="datetime" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col mb-4">
                            <label for="foto">Unggah Foto (opsional)</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control @error('foto') is-invalid @enderror">
                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- <div class="col mb-4 d-none" id="jumlah_nominal_akhir_div">
                            <label for="jumlah_nominal_akhir">Jumlah Nominal Akhir</label>
                            <input type="text"
                                class="form-control money @error('jumlah_nominal_akhir') is-invalid @enderror"
                                id="jumlah_nominal_akhir" name="jumlah_nominal_akhir"
                                value="{{ old('jumlah_nominal_akhir') }}">
                            @error('jumlah_nominal_akhir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}

                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

        <script>
            $('#nama_cuti_ajax').select2();

            $(document).ready(function() {
                // $('.numeric').mask('000000000000000', {
                //     reverse: true
                // });

                $('.money').mask('000,000,000,000,000', {
                    reverse: true
                });

                $('#tipe').change(function() {
                    if ($(this).val() == 'Deskriptif') {
                        $('#jumlah_nominal_div').addClass('d-none');
                    } else {
                        $('#jumlah_nominal_div').removeClass('d-none');
                    }
                });
            });
        </script>
    @endpush
@endsection
