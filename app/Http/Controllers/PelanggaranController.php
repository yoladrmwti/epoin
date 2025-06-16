<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index(): View
    {
        // Ambil data pelanggaran terbaru dan paginasi 10 per halaman
        $pelanggarans = Pelanggaran::latest()->paginate(10);

        // Jika ada parameter pencarian, gunakan method search
        if (request('cari')) {
            $pelanggarans = $this->search(request('cari'));
        }

        return view('admin.pelanggaran.index', compact('pelanggarans'));
    }

    public function create(): View
    {
        return view('admin.pelanggaran.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'jenis' => 'required|string|max:250',
            'konsekuensi' => 'required|string|max:250',
            'poin' => 'required|numeric'
        ]);

        Pelanggaran::create([
            'jenis' => $request->jenis,
            'konsekuensi' => $request->konsekuensi,
            'poin' => $request->poin
        ]);

        return redirect()->route('pelanggaran.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function search(string $cari): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $pelanggarans = DB::table('pelanggarans')
            ->where(DB::raw('lower(jenis)'), 'like', '%' . strtolower($cari) . '%')
            ->paginate(10);

        return $pelanggarans;
    }

    public function edit(string $id): View
    {
        $pelanggaran = Pelanggaran::findOrFail($id);

        return view('admin.pelanggaran.edit', compact('pelanggaran'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'jenis' => 'required|string|max:250',
            'konsekuensi' => 'required|string|max:250',
            'poin' => 'required|numeric'
        ]);

        $pelanggaran = Pelanggaran::findOrFail($id);

        $pelanggaran->update([
            'jenis' => $request->jenis,
            'konsekuensi' => $request->konsekuensi,
            'poin' => $request->poin
        ]);

        return redirect()->route('pelanggaran.edit', $id)->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id): RedirectResponse
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();

        return redirect()->route('pelanggaran.index')->with(['success' => 'Data pelanggaran berhasil dihapus!']);
    }
}
