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
                        <a href="{{ url('/data-pelanggan') }}" class="btn btn-danger btn-sm ms-2">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <form method="post" action="{{ url('/data-pelanggan/update/' . $pelanggan->id) }}" class="p-4">
                    @csrf
                    @method("put")
                    <div class="form-row">
                        <div class="col mb-4">
                            <label for="nama">Nama Pelanggan</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ $pelanggan->nama }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-4">
                            <label for="nama">Nomor Telepon Pelanggan</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                id="no_telepon" name="no_telepon" value="{{ $pelanggan->no_telepon }}">
                            @error('no_telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col mb-4">
                            <label for="nama">Nomor Telepon PIC</label>
                            <input type="text" class="form-control @error('no_telepon_pic') is-invalid @enderror"
                                id="no_telepon_pic" name="no_telepon_pic" value="{{ $pelanggan->no_telepon_pic }}">
                            @error('no_telepon_pic')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col mb-4">
                            <label for="nama">Alamat Pelanggan</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                            name="alamat" rows="3">{{ $pelanggan->alamat }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <div class="col mb-4">
                            <label for="tipe">Tipe Pelanggan</label>
                            <select name="tipe" id="tipe" class="form-control">
                                <option value="">Pilih Tipe Pelanggan</option>
                                <option @if ($pelanggan->tipe == 'Perorangan') selected @endif value="Perorangan">Perorangan
                                </option>
                                <option @if ($pelanggan->tipe == 'Perusahaan') selected @endif value="Perusahaan">Perusahaan
                                </option>
                                <option @if ($pelanggan->tipe == 'Toko') selected @endif value="Toko">Toko</option>
                                <option @if ($pelanggan->tipe == 'Lainnya') selected @endif value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            $('#tipe').select2();
        </script>
    @endpush
@endsection
