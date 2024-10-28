<?php

namespace App\Http\Controllers;

use App\Models\POI;
use App\Models\Cuti;
use App\Models\DetailPOI;
use App\Models\User;
use App\Models\Pelanggan;
use App\Models\KategoriPOI;
use App\Models\MappingShift;
use App\Models\PermintaanPOI;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class PoiController extends Controller
{
    public function index()
    {
        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');

        $poi = POI::when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
            return $query->where(function ($q) use ($mulai, $akhir) {
                $q->whereBetween('tanggal_mulai', [$mulai, $akhir])->orWhereNull('tanggal_mulai');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('poi.datapoi', [
            'title' => 'Data POI Pegawai',
            'data_poi' => $poi,
        ]);
    }

    public function create()
    {
        return view('poi.tambahpoi', [
            'title' => 'Tambah POI Pegawai',
            'data_pelanggan' => Pelanggan::orderBy('nama', 'ASC')->get(),
            'data_pegawai' => User::where('is_admin', '!=', 'admin')->orderBy('name', 'ASC')->get(),
            'data_kategori_poi' => KategoriPOI::orderBy('kategori', 'ASC')->get(),
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        date_default_timezone_set('Asia/Jakarta');

        $request->validate(
            [
                // "pegawai_id" => "required",
                'pelanggan_id' => 'required',
                'kategori_poi_id' => 'required',
                'target' => 'required',
                'tipe' => 'required',
            ],
            [
                // "pegawai_id.required" => "Pegawai harus diisi",
                'pelanggan_id.required' => 'Pelanggan harus diisi',
                'kategori_poi_id.required' => 'Kategori POI harus diisi',
                'target.required' => 'Target POI harus diisi',
                'tipe.required' => 'Tipe POI harus diisi',
            ],
        );

        if ($request->tipe == 'Kuantitas' && $request->jumlah_nominal <= 0) {
            $request['jumlah_nominal'] = 0;
        } elseif ($request->tipe == 'Kuantitas') {
            $request['jumlah_nominal'] = str_replace(',', '', $request['jumlah_nominal']);
        }

        $poi = new POI();
        $poi->pegawai_id = $request->pegawai_id;
        $poi->pelanggan_id = $request->pelanggan_id;
        $poi->kategori_poi_id = $request->kategori_poi_id;
        $poi->target = $request->target;
        $poi->tipe = $request->tipe;
        $poi->tanggal_mulai = $request->tanggal_mulai;
        $poi->jumlah_nominal = $request->jumlah_nominal;
        $poi->tanggal = Carbon::now()->toDateString();
        $poi->lat_poi = $request->lat_poi;
        $poi->long_poi = $request->long_poi;

        if ($request->hasFile('foto')) {
            $poi->foto = $request->file('foto')->store('foto_poi/poi');
        }

        $poi->save();

        return redirect('/data-poi')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function show($id)
    {
        $poi = POI::find($id);

        if (!$poi) {
            return redirect('/data-poi');
        }

        return view('poi.detailpoi', [
            'title' => 'Detail POI',
            'poi' => $poi,
            'data_user' => auth()->user(),
        ]);
    }

    public function edit($id)
    {
        $poi = POI::find($id);

        if (!$poi) {
            return redirect('/data-poi');
        }

        return view('poi.editpoi', [
            'title' => 'Edit POI Pegawai',
            'poi' => $poi,
            'data_pelanggan' => Pelanggan::orderBy('nama', 'ASC')->get(),
            'data_pegawai' => User::where('is_admin', '!=', 'admin')->orderBy('name', 'ASC')->get(),
            'data_kategori_poi' => KategoriPOI::orderBy('kategori', 'ASC')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate(
            [
                // "pegawai_id" => "required",
                'pelanggan_id' => 'required',
                // 'kategori_poi_id' => 'required',
                'target' => 'required',
                'tipe' => 'required',
                'status' => 'required',
            ],
            [
                // "pegawai_id.required" => "Pegawai harus diisi",
                'pelanggan_id.required' => 'Pelanggan harus diisi',
                // 'kategori_poi_id.required' => 'Kategori POI harus diisi',
                'target.required' => 'Target POI harus diisi',
                'tipe.required' => 'Tipe POI harus diisi',
                'status.required' => 'Status POI harus diisi',
            ],
        );

        $poi = POI::find($id);

        if (!$poi) {
            return redirect('/data-poi');
        }

        if($request->status == 'Pending') {
            // dd($poi->status);
            if($poi->status != 'Pending' && $poi->status != 'In Progress' && $poi->status != 'Cancel' && $poi->status != 'Expired') return redirect()->back()->with('error', 'Status POI Telah Berubah!');
        }

        elseif($request->status == 'In Progress') {
            // dd("2");
            if($poi->status != 'In Progress') return redirect()->back()->with('error', 'Status POI Telah Berubah!');
        }

        elseif($request->status == 'Done') {
            // dd("3");
            if($poi->status != 'Done') return redirect()->back()->with('error', 'Status POI Telah Berubah!');
        }

        elseif($request->status == 'Cancel') {
            // dd("4");
            if($poi->status != 'Cancel' && $poi->status != 'Pending' && $poi->status != 'Expired') return redirect()->back()->with('error', 'Status POI Telah Berubah!');
        }

        if ($request->tipe == 'Kuantitas' && $request->jumlah_nominal <= 0) {
            $request['jumlah_nominal'] = 0;
        }
        // elseif($request->tipe == "Kuantitas") $request['jumlah_nominal'] = str_replace(',', '', $request['jumlah_nominal']);

        $poi->pegawai_id = $request->pegawai_id;
        $poi->pelanggan_id = $request->pelanggan_id;
        $poi->kategori_poi_id = $request->kategori_poi_id;
        $poi->target = $request->target;
        $poi->tipe = $request->tipe;
        $poi->tanggal_mulai = $request->tanggal_mulai;
        $poi->jumlah_nominal = $request->jumlah_nominal ? ($request['jumlah_nominal'] = str_replace(',', '', $request['jumlah_nominal'])) : $poi->jumlah_nominal;
        $poi->tanggal = Carbon::now()->toDateString();

        $poi->lat_poi = $request->lat_poi;
        $poi->long_poi = $request->long_poi;
        $poi->status = $request->status;

        if ($request->hasFile('foto')) {
            if ($poi->foto) {
                Storage::delete($poi->foto);
            }
            $poi->foto = $request->file('foto')->store('foto_poi/poi');
        }

        $poi->save();

        return redirect('/data-poi')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $poi = POI::find($id);

        if (!$poi) {
            return redirect('/data-poi');
        }

        if ($poi->foto) {
            Storage::delete($poi->foto);
        }

        if ($poi->DetailPOI) {
            if ($poi->DetailPOI->foto) {
                Storage::delete($poi->DetailPOI->foto);
            }
            if ($poi->DetailPOI->tanda_tangan) {
                Storage::delete($poi->DetailPOI->tanda_tangan);
            }
            $poi->DetailPOI->delete();
        }

        $poi->delete();

        return redirect('/data-poi')->with('success', 'Data Berhasil Dihapus');
    }

    // ===================

    public function indexInboxPoi()
    {
        $search = request()->input('search');

        $data = POI::when($search, function ($query) use ($search) {
            $query->where('target', 'LIKE', '%' . $search . '%');
        })
            ->where('pegawai_id', auth()->user()->id)
            ->paginate(10)
            ->withQueryString();

        return view('poi.user.inboxpoi', [
            'title' => 'Inbox POI',
            'data_poi' => $data,
        ]);
    }

    public function showInboxPoi($id)
    {
        $user = auth()->user();
        $data = POI::where('id', $id)
            ->where('pegawai_id', $user->id)
            ->first();

        if (!$data) {
            return redirect('/inbox-poi');
        }

        return view('poi.user.requestpoidetail', [
            'title' => 'Detail POI',
            'poi' => $data,
            'data_user' => $user,
        ]);
    }

    public function changeStatusInboxPoi(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $mp = MappingShift::where('user_id', auth()->user()->id)
                            ->where('tanggal', Carbon::now()->toDateString())
                            ->where('jam_absen', '!=', null)
                            ->first();

        if(!$mp) {
            return redirect()->back()->with('error', 'Sebelum Memulai, Silahkan Absen Terlebih Dahulu!');
        }


        $user = auth()->user();
        $data = POI::where('id', $id)
            ->where('pegawai_id', $user->id)
            ->first();

        if (!$data) {
            return redirect('/inbox-poi');
        }

        if ($data->status == 'Expired') {
            return redirect()->back()->with('error', 'Kamu Terlambat Untuk Memulai, POI Telah Expired. Silahkan Hubungi Admin Untuk Melanjutkan!');
        }

        if ($request->status == 'In Progress') {
            $message = '';
            $type = 'success';

            if ($data->tanggal_mulai && Carbon::now()->toDateString() > $data->tanggal_mulai) {
                $data->status = 'Expired';
                $message = 'Kamu Terlambat Untuk Memulai, POI Telah Expired. Silahkan Hubungi Admin Untuk Melanjutkan!';
                $type = 'error';
            } else {
                $message = 'Status POI Telah Berubah Menjadi In Progress';
                $data->status = 'In Progress';
            }

            $data->save();

            return redirect()->back()->with($type, $message);
        } elseif ($request->status == 'Done') {
            return redirect()->back();
            // dd("status done");
        }
    }

    public function inboxPoiDetailProcess(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');

        $request->validate(
            [
                'pesan' => 'required',
                'foto' => 'required|file|mimes:png,jpg,jpeg|max:2048',
                'signed' => 'required',
            ],
            [
                'pesan.required' => 'Pesan Tidak Boleh Kosong',
                'signed.required' => 'Tanda Tangan Tidak Boleh Kosong',
                'foto.required' => 'Foto Tidak Boleh Kosong',
                'foto.mimes' => 'File Harus Berupa PNG, JPG, atau JPEG',
                'foto.max' => 'File Maksimal 2 MB',
            ],
        );

        $poi = POI::where('id', $id)
            ->where('pegawai_id', auth()->user()->id)
            ->where('status', 'In Progress')
            ->first();

        if (!$poi) {
            return redirect()->back();
        }

        $permintaanPoi = new DetailPOI();
        $permintaanPoi->poi_id = $poi->id;
        $permintaanPoi->pegawai_id = auth()->user()->id;
        $permintaanPoi->pesan = $request->pesan;
        $permintaanPoi->foto = $request->file('foto')->store('foto_poi/detail_poi');

        $image_parts = explode(';base64,', $request->signed);
        $image_type_aux = explode('image/', $image_parts[0]);
        $image_type = $image_type_aux[1] ?? '';
        $image_base64 = base64_decode($image_parts[1] ?? '');
        $fileName = uniqid() . time() . '.' . $image_type;
        Storage::put('foto_poi/detail_poi/tanda_tangan_poi/' . $fileName, $image_base64);

        $permintaanPoi->tanda_tangan = 'foto_poi/detail_poi/tanda_tangan_poi/' . $fileName;

        $permintaanPoi->save();

        $poi->status = 'Done';
        $poi->save();

        return redirect()->back()->with('success', 'POI Telah Selesai');
    }
}
