<?php

namespace App\Http\Controllers;

use App\Models\KategoriPOI;
use Illuminate\Http\Request;

class KategoriPOIController extends Controller
{
    public function index()
    {
        $search = request()->input('search');

        $kategori_poi = KategoriPOI::when($search, function ($query) use ($search) {
            $query
                ->where('kategori', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('kategori', 'ASC')
            ->paginate(10)
            ->withQueryString();

        return view('poi.kategori.datakategoripoi', [
            'title' => 'Data Kategori POI',
            'data_kategori_poi' => $kategori_poi,
        ]);
    }

    public function create()
    {
        return view('poi.kategori.tambahkategoripoi', [
            'title' => 'Tambah Kategori POI',
        ]);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate(
            [
                'kategori' => 'required|unique:kategori_poi,kategori',
            ],
            [
                'kategori.required' => 'Kategori Tidak Boleh Kosong',
                'kategori.unique' => 'Kategori POI Telah Digunakan',
            ],
        );

        KategoriPOI::create($request->all());

        return redirect('/data-kategori-poi')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $kategori_poi = KategoriPOI::find($id);

        if (!$kategori_poi) {
            return redirect('/data-kategori-poi');
        }

        return view('poi.kategori.editkategoripoi', [
            'title' => 'Edit Kategori POI - ' . $kategori_poi->nama,
            'kategori_poi' => $kategori_poi,
        ]);
    }

    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate(
            [
                'kategori' => 'required|unique:kategori_poi,kategori,' . $id,
            ],
            [
                'kategori.required' => 'Kategori Tidak Boleh Kosong',
                'kategori.unique' => 'Kategori POI Telah Digunakan',
            ],
        );

        $kategori_poi = KategoriPOI::find($id);

        if (!$kategori_poi) {
            return redirect('/data-kategori-poi');
        }

        $kategori_poi->update($request->all());

        return redirect('/data-kategori-poi')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $kategori_poi = KategoriPOI::find($id);

        if (!$kategori_poi) {
            return redirect('/data-kategori-poi');
        }

        $kategori_poi->delete();

        return redirect('/data-kategori-poi')->with('success', 'Data Berhasil Dihapus');
    }
}
