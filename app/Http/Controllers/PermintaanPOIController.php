<?php

namespace App\Http\Controllers;

use App\Models\PermintaanPOI;
use App\Models\POI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PermintaanPOIController extends Controller
{
    public function index($id)
    {
        $poi = POI::find($id);

        if (!$poi || $poi->pegawai_id != null) {
            return redirect('/data-poi');
        }

        return view('poi.permintaanpoi', [
            'title' => 'Permintaan Penugasan',
            'poi' => $poi,
            'data_user' => auth()->user(),
        ]);
    }

    public function processPermintaanPOI(Request $request, $id)
    {
        $permintaanPoi = PermintaanPOI::find($id);

        if (!$permintaanPoi || $permintaanPoi->POI->pegawai_id != null) {
            return redirect()->back();
        }

        $permintaanPoi->status = $request->status;

        if ($request->status == 'Diterima') {
            $permintaanPoi->POI->pegawai_id = $request->pegawai_id;
            $permintaanPoi->POI->save();

            $permintaanPoi->save();

            return redirect('/data-poi')->with('success', 'Permintaan POI diterima');
        } else {
            $permintaanPoi->save();

            return redirect()->back();
        }
    }

    // ==============

    public function indexRequestPoi()
    {
        $search = request()->input('search');

        $data = POI::whereDoesntHave('PermintaanPOI', function ($query) {
            $query->where('pegawai_id', auth()->user()->id);
        })
            ->when($search, function ($query) use ($search) {
                $query->where('target', 'LIKE', '%' . $search . '%');
            })
            ->where('pegawai_id', null)
            ->paginate(10)
            ->withQueryString();

        return view('poi.user.requestpoi', [
            'title' => 'Request Penugasan',
            'data_poi' => $data,
        ]);
    }

    public function myRequestPoi()
    {
        $search = request()->input('search');

        $data = POI::whereHas('PermintaanPOI', function ($query) {
            $query->where('pegawai_id', auth()->user()->id);
        })
            ->when($search, function ($query) use ($search) {
                $query->where('target', 'LIKE', '%' . $search . '%');
            })
            ->where('pegawai_id', null)
            ->paginate(10)
            ->withQueryString();

        return view('poi.user.requestpoimy', [
            'title' => 'Request Penugasan Saya',
            'data_poi' => $data,
        ]);
    }

    public function showRequestPoi($id)
    {
        // $data = POI::whereDoesntHave('PermintaanPOI', function ($query) {
        //     $query->where('pegawai_id', auth()->user()->id);
        // })
        //     ->where('id', $id)
        //     ->first();

        $data = POI::where('id', $id)->where('pegawai_id', null)->first();

        if (!$data) {
            return redirect()->back();
        }

        $sudahRequest = $data->PermintaanPOI->where('pegawai_id', auth()->user()->id)->first();

        return view('poi.user.requestpoidetail', [
            'title' => 'Detail Penugasan',
            'poi' => $data,
            'data_user' => User::find(auth()->user()->id),
            'sudahRequest' => $sudahRequest
        ]);
    }

    public function requestPoiProcess($id)
    {
        $poi = POI::find($id);

        if (!$poi || $poi->pegawai_id != null) {
            return redirect()->back();
        }

        $permintaanPoi = PermintaanPOI::where('poi_id', $poi->id)
            ->where('pegawai_id', auth()->user()->id)
            ->first();

        if ($permintaanPoi) {
            return redirect()->back();
        }

        $permintaanPoi = new PermintaanPOI();
        $permintaanPoi->poi_id = $poi->id;
        $permintaanPoi->pegawai_id = auth()->user()->id;
        $permintaanPoi->tanggal = Carbon::now()->toDateString();
        $permintaanPoi->save();

        return redirect('/request-penugasan')->with('success', 'Permintaan POI berhasil dikirim');
    }
}
