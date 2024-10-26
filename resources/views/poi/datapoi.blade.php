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
                        <a class="btn btn-primary btn-sm" href="{{ url('/data-poi/tambah') }}">+ Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url('/data-poi') }}">
                        <div class="row">
                            <div class="col-3">
                                <input type="datetime" class="form-control" name="mulai" placeholder="Tanggal Mulai"
                                    id="mulai" value="{{ request('mulai') }}">
                            </div>
                            <div class="col-3">
                                <input type="datetime" class="form-control" name="akhir" placeholder="Tanggal Akhir"
                                    id="akhir" value="{{ request('akhir') }}">
                            </div>
                            <div class="col-3">
                                <button type="submit" id="search"class="border-0 mt-3"
                                    style="background-color: transparent;"><i class="fas fa-search"></i></button>
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
                                    <th>Pelanggan</th>
                                    <th>Pegawai</th>
                                    <th>Tanggal</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Target</th>
                                    <th>Foto</th>
                                    {{-- <th>Kategori</th> --}}
                                    {{-- <th>Tipe</th> --}}
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_poi as $poi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $poi->Pelanggan ? $poi->Pelanggan->nama : '-' }}</td>
                                        <td>{{ $poi->Pegawai ? $poi->Pegawai->name : '-' }}</td>
                                        <td>{{ $poi->tanggal }}</td>
                                        <td>{{ $poi->tanggal_mulai ? $poi->tanggal_mulai : '-' }}</td>
                                        <td>
                                            {{ $poi->target }}
                                            <br>
                                            <span class="badge badge-info">{{ $poi->tipe }}</span>
                                            <span
                                                class="badge badge-info">{{ $poi->KategoriPOI ? $poi->KategoriPOI->kategori : '' }}</span>
                                        </td>
                                        </td>
                                        <td>
                                            @if ($poi->foto)
                                                <img src="{{ url('storage/' . $poi->foto) }}" style="width: 70px"
                                                    alt="{{ $poi->target }}">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        {{-- <td>{{ $poi->KategoriPOI->kategori }}</td> --}}
                                        {{-- <td>{{ $poi->tipe}}</td> --}}
                                        <td>
                                            @if ($poi->status == 'Pending')
                                                <span class="badge badge-info">{{ $poi->status }}</span>
                                            @elseif($poi->status == 'In Progress')
                                                <span class="badge badge-warning">{{ $poi->status }}</span>
                                            @elseif($poi->status == 'Done')
                                                <span class="badge badge-success">{{ $poi->status }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $poi->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="action">
                                                @if ($poi->pegawai_id == null)
                                                    <li class="mr-2" style="margin-right: 6px">
                                                        <a href="{{ url('/data-poi/permintaan/' . $poi->id) }}"><i
                                                                style="color: orange" class="fas fa-briefcase"></i></a>
                                                    </li>
                                                @endif

                                                <li style="margin-right: 6px">
                                                    <a href="{{ url('/data-poi/detail/' . $poi->id) }}"><i
                                                            style="color: blue" class="fas fa-eye"></i></a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('/data-poi/edit/' . $poi->id) }}"><i
                                                            style="color: green" class="fas fa-edit"></i></a>
                                                </li>

                                                <li class="delete">
                                                    <form action="{{ url('/data-poi/delete/' . $poi->id) }}" method="post"
                                                        class="d-inline">
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
                        {{ $data_poi->links() }}
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
