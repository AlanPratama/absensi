<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;

class PoiController extends Controller
{
    public function index()
    {
        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');

        $cuti = Cuti::when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
                        return $query->whereBetween('tanggal', [$mulai, $akhir]);

                    })
                    ->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('poi.datapoi', [
            'title' => 'Data POI Pegawai',
            'data_cuti' => $cuti
        ]);
    }

    public function tambahPOI()
    {
        return view('cuti.tambahadmin', [
            'title' => 'Tambah POI Pegawai',
            'data_user' => User::select('id', 'name')->get()
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
