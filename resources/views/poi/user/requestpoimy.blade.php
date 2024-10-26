@extends('templates.app')
@section('container')
    <div class="card-secton transfer-section">
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="tf-spacing-16"></div>

                <div class="bill-content">
                    <form action="{{ url('/request-poi/my') }}">
                        <div class="row">
                            <div class="col-10">
                                <div class="input-field">
                                    <span class="icon-search"></span>
                                    <input class="search-field value_input" placeholder="Search" name="search"
                                        type="text" value="{{ request('search') }}">
                                    <span class="icon-clear"></span>
                                </div>
                            </div>
                            <div class="col-2">

                                <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tf-spacing-16"></div>
            </div>
        </div>
    </div>
        <div id="app-wrap">
            <div class="bill-content">
                <div class="tf-container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="fw_6 d-flex justify-content-between mt-3">{{ $title }}</h3>
                    </div>
                    <ul class="mt-3 mb-5">

                        @foreach ($data_poi as $poi)
                            <li class="list-card-invoice tf-topbar d-flex justify-content-between align-items-center">
                                <div class="poi-info">
                                    @if ($poi->foto == null)
                                        <img src="{{ url('/assets/img/no-data.png') }}" alt="image">
                                    @else
                                        <img src="{{ url('/storage/' . $poi->foto) }}" alt="image">
                                    @endif
                                </div>
                                <div class="content-right">
                                    <h4><a
                                            href="{{ url('/request-poi/detail/' . $poi->id) }}">{{ $poi->target }}
                                            <span class="primary_color">View</span></a></h4>
                                    <p>
                                        {{ $poi->tipe ?? '-' }} <br>
                                        {{ $poi->tanggal_mulai ?? '- tidak ada tanggal mulai' }}
                                    </p>
                                </div>
                            </li>
                        @endforeach
                        <div class="d-flex justify-content-end me-4 mt-4">
                            {{ $data_poi->links() }}
                        </div>
                    </ul>

                </div>
            </div>
        </div>
@endsection
