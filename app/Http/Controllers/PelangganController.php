<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        // $mulai = request()->input('mulai');
        // $akhir = request()->input('akhir');

        // $cuti = Cuti::when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
        //                 return $query->whereBetween('tanggal', [$mulai, $akhir]);

        //             })
        //             ->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $search = request()->input('search');

        $pelanggan = Pelanggan::when($search, function ($query) use ($search) {
            $query
                ->where('nama', 'LIKE', '%' . $search . '%')
                ->orWhere('no_telepon', 'LIKE', '%' . $search . '%')
                ->orWhere('no_telepon_pic', 'LIKE', '%' . $search . '%')
                ->orWhere('alamat', 'LIKE', '%' . $search . '%');
            })
            ->orderBy('nama', 'ASC')
            ->paginate(10)
            ->withQueryString();

        return view('pelanggan.datapelanggan', [
            'title' => 'Data Pelanggan',
            'data_pelanggan' => $pelanggan,
        ]);
    }

    public function create()
    {
        return view('pelanggan.tambahpelanggan', [
            'title' => 'Tambah Pelanggan',
        ]);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate(
            [
                'nama' => 'required',
                'no_telepon' => 'required ',
                'no_telepon_pic' => 'required',
                'alamat' => 'required',
            ],
            [
                'nama.required' => 'Nama Pelanggan Tidak Boleh Kosong',
                'no_telepon.required' => 'No Telepon Tidak Boleh Kosong',
                'no_telepon_pic.required' => 'No Telepon PIC Tidak Boleh Kosong',
                'alamat.required' => 'Alamat Pelanggan Tidak Boleh Kosong',
            ],
        );

        Pelanggan::create($request->all());

        return redirect('/data-pelanggan')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return redirect('/data-pelanggan');
        }

        return view('pelanggan.editpelanggan', [
            'title' => 'Edit Pelanggan ' . $pelanggan->nama,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate(
            [
                'nama' => 'required',
                'no_telepon' => 'required',
                'no_telepon_pic' => 'required',
                'alamat' => 'required',
            ],
            [
                'nama.required' => 'Nama Pelanggan Tidak Boleh Kosong',
                'no_telepon.required' => 'No Telepon Tidak Boleh Kosong',
                'no_telepon_pic.required' => 'No Telepon PIC Tidak Boleh Kosong',
                'alamat.required' => 'Alamat Pelanggan Tidak Boleh Kosong',
            ],
        );

        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return redirect('/data-pelanggan');
        }

        $pelanggan->update($request->all());

        return redirect('/data-pelanggan')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return redirect('/data-pelanggan');
        }

        $pelanggan->delete();

        return redirect('/data-pelanggan')->with('success', 'Data Berhasil Dihapus');
    }
}
