@extends('templates.dashboard')
@section('isi')
    <div class="row">
        <div class="col-md-12 project-list">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 mt-2 p-0 d-flex">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="col-md-6 p-0">
                        <a class="btn btn-primary btn-sm" href="{{ url('/data-pelanggan/tambah') }}">+ Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url('/data-pelanggan') }}">
                        <div class="row mb-2">
                            <div class="col-2">
                                <input type="text" placeholder="Search...." class="form-control" value="{{ request('search') }}" name="search">
                            </div>
                            <div class="col">
                                <button type="submit" id="search"class="border-0 mt-3" style="background-color: transparent;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pelanggan</th>
                                    <th>No Telepon</th>
                                    <th>No Telepon PIC</th>
                                    <th>Alamat</th>
                                    <th>Tipe</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_pelanggan as $pelanggan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pelanggan->nama }}</td>
                                        <td>{{ $pelanggan->no_telepon }}</td>
                                        <td>{{ $pelanggan->no_telepon_pic }}</td>
                                        <td>{{ $pelanggan->alamat }}</td>
                                        <td>{{ $pelanggan->tipe }}</td>
                                        <td>
                                            <ul class="action">
                                                <li>
                                                    <a href="{{ url('/data-pelanggan/edit/' . $pelanggan->id) }}"><i
                                                            style="color: blue" class="fas fa-edit"></i></a>
                                                </li>
                                                <li class="delete">
                                                    <form action="{{ url('/data-pelanggan/delete/' . $pelanggan->id) }}"
                                                        method="post" class="d-inline">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="border-0" style="background-color: transparent"
                                                            onClick="return confirm('Are You Sure')"><i
                                                                class="fas fa-trash"></i></button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mr-4">
                        {{ $data_pelanggan->links() }}
                    </div>
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
