<?php

namespace App\Http\Controllers;

use App\Models\Pelanggar;
use App\Models\DetailPelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PelanggarController extends Controller
{
    public function index(): View
    {
        $id_pelanggars = DB::table('pelanggars')->pluck('id_siswa')->toArray();

        $pelanggars = DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select(
                'pelanggars.*',
                'siswas.image',
                'siswas.nis',
                'siswas.tingkatan',
                'siswas.jurusan',
                'siswas.kelas',
                'siswas.hp',
                'users.name',
                'users.email'
            )->whereIn('siswas.id', $id_pelanggars)
            ->latest()->paginate(10);

        if (request('cari')) {
            $pelanggars = $this->searchPelanggar(request('cari'), $id_pelanggars);
        }

        return view('admin.pelanggar.index', compact('pelanggars'));
    }

    public function searchPelanggar(string $cari, $id)
    {
        return DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select(
                'pelanggars.*',
                'siswas.image',
                'siswas.nis',
                'siswas.tingkatan',
                'siswas.jurusan',
                'siswas.kelas',
                'siswas.hp',
                'users.name',
                'users.email'
            )->whereIn('siswas.id', $id)
            ->where(function($query) use ($cari) {
                $query->where('users.name', 'like', "%$cari%")
                      ->orWhere('siswas.nis', 'like', "%$cari%");
            })
            ->latest()->paginate(10);
    }

    public function create(): View
    {
        $id_pelanggars = DB::table('pelanggars')->pluck('id_siswa')->toArray();

        $siswas = DB::table('siswas')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('siswas.*', 'users.name', 'users.email')
            ->whereNotIn('siswas.id', $id_pelanggars)
            ->latest()->paginate(10);

        if (request('cari')) {
            $siswas = $this->searchSiswa(request('cari'), $id_pelanggars);
        }

        return view('admin.pelanggar.create', compact('siswas'));
    }

    public function searchSiswa(string $cari, $id)
    {
        return DB::table('siswas')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('siswas.*', 'users.name', 'users.email')
            ->whereNotIn('siswas.id', $id)
            ->where(function($query) use ($cari) {
                $query->where('users.name', 'like', "%$cari%")
                      ->orWhere('siswas.nis', 'like', "%$cari%");
            })
            ->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required'
        ]);

        Pelanggar::create([
            'id_siswa' => $request->id_siswa,
            'poin_pelanggar' => 0,
            'status_pelanggar' => 0,
            'status' => 0
        ]);

        $idPelanggar = Pelanggar::where('id_siswa', $request->id_siswa)->value('id');

        return redirect()->route('pelanggar.show', $idPelanggar);
    }

    public function show(string $id)
    {
        $pelanggar = DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select(
                'pelanggars.*',
                'siswas.image',
                'siswas.nis',
                'siswas.tingkatan',
                'siswas.jurusan',
                'siswas.kelas',
                'siswas.hp',
                'siswas.status',
                'users.name',
                'users.email'
            )->where('pelanggars.id', $id)->first();

        $pelanggarans = DB::table('pelanggarans')->latest()->paginate(10);

        if (request('cari')) {
            $pelanggarans = $this->searchPelanggaran(request('cari'));
        }

        $idUser = Auth::user()->id;

        return view('admin.pelanggar.show', compact('pelanggar', 'pelanggarans', 'idUser'));
    }

    public function searchPelanggaran(string $cari)
    {
        return DB::table('pelanggarans')
            ->where(DB::raw('lower(jenis)'), 'like', '%' . strtolower($cari) . '%')
            ->paginate(10);
    }

    public function storePelanggaran(Request $request)
    {
        $request->validate([
            'id_pelanggar' => 'required',
            'id_pelanggaran' => 'required',
            // 'status' => 'required' // tidak perlu divalidasi, kita set default
        ]);

        DetailPelanggaran::create([
            'id_pelanggar' => $request->id_pelanggar,
            'id_pelanggaran' => $request->id_pelanggaran,
            'id_user' => $request->id_user,
            'status' => 0
        ]);

        $this->updatePoin($request->id_pelanggaran, $request->id_pelanggar);

        return redirect()->route('pelanggar.show', $request->id_pelanggar)->with('success', 'Data Berhasil Disimpan!');
    }

    function updatePoin(string $id_pelanggaran, string $id_pelanggar)
    {
        $poin = $this->calculatedPoin($id_pelanggaran, $id_pelanggar);
        $datas = Pelanggar::findOrFail($id_pelanggar);

        $datas->update(['poin_pelanggar' => $poin]);
        $this->updateStatus($datas, $poin);
    }

    function calculatedPoin(string $id_pelanggaran, string $id_pelanggar)
    {
        $poin_pelanggaran = DB::table('pelanggarans')->where('id', $id_pelanggaran)->value('poin');
        $poin_pelanggar = DB::table('pelanggars')->where('id', $id_pelanggar)->value('poin_pelanggar');
        return $poin_pelanggar + $poin_pelanggaran;
    }

    function updateStatus($datas, $poin)
    {
        if ($poin >= 0 && $poin < 15) {
            $datas->update(['status_pelanggar' => 0, 'status' => 0]);
        } elseif ($poin >= 15 && $poin < 20) {
            if (1 > $datas->status_pelanggar && $datas->status == 0) {
                $datas->update(['status_pelanggar' => 1, 'status' => 1]);
            }
        } elseif ($poin >= 20 && $poin < 30) {
            if (2 > $datas->status_pelanggar && $datas->status == 2) {
                $datas->update(['status_pelanggar' => 2, 'status' => 1]);
            }
        } elseif ($poin >= 30 && $poin < 40) {
            if (3 > $datas->status_pelanggar && $datas->status == 2) {
                $datas->update(['status_pelanggar' => 3, 'status' => 1]);
            }
        } elseif ($poin >= 40 && $poin < 50) {
            if (4 > $datas->status_pelanggar && $datas->status == 2) {
                $datas->update(['status_pelanggar' => 4, 'status' => 1]);
            }
        } elseif ($poin >= 50 && $poin < 100) {
            if (5 > $datas->status_pelanggar && $datas->status == 2) {
                $datas->update(['status_pelanggar' => 5, 'status' => 1]);
            }
        } elseif ($poin >= 100) {
            if (6 > $datas->status_pelanggar && $datas->status == 2) {
                $datas->update(['status_pelanggar' => 6, 'status' => 1]);
            }
        }
    }

    public function statusTindak($id)
    {
        $datas = Pelanggar::findOrFail($id);

        $pelanggar = DB::table('pelanggars')
            ->join('siswas', 'pelanggars.id_siswa', '=', 'siswas.id')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('users.name')
            ->where('pelanggars.id', $id)
            ->first();

        $datas->update(['status' => 2]);

        return redirect()->route('pelanggar.index')->with(['success' => $pelanggar->name . ' Telah Ditindak!']);
    }

    public function destroy($id): RedirectResponse
    {
        $this->destroyPelanggaran($id);

        $post = Pelanggar::findOrFail($id);
        $post->delete();

        return redirect()->route('pelanggar.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function destroyPelanggaran(string $id)
    {
        DB::table('detail_pelanggarans')->where('id_pelanggar', $id)->delete();
    }
}
