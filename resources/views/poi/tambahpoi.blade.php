@extends('templates.dashboard')
@section('isi')
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
                            <label for="pegawai_id">Nama Pegawai</label>
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
                                <option @if (old('tipe') == 'Kuantitas') selected @endif value="Kuantitas">Kuantitas</option>
                                <option @if (old('tipe') == 'Deskriptif') selected @endif value="Deskriptif">Deskriptif</option>
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
                            <input type="numeric" class="form-control numeric @error('lat_poi') is-invalid @enderror" id="lat_poi"
                                name="lat_poi" value="{{ old('lat_poi') }}">
                            @error('lat_poi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4">
                            <label for="long_poi">Long POI (opsional)</label>
                            <input type="numeric" class="form-control numeric @error('long_poi') is-invalid @enderror"
                                id="long_poi" name="long_poi" value="{{ old('long_poi') }}">
                            @error('long_poi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-4">
                            <label for="tanggal_mulai">Tanggal Mulai (opsional)</label>
                            <input type="datetime" class="form-control @error('tanggal_mulai') is-invalid @enderror" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
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
