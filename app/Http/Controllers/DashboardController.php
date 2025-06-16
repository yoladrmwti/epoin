<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pelanggar;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total siswa dan pelanggar
        $jmlSiswas = Siswa::count();
        $jmlPelanggars = Pelanggar::count();

        // Ambil top 10 pelanggar berdasarkan poin tertinggi
        $pelanggars = Pelanggar::orderByDesc('poin_pelanggar')->limit(10)->get();

        // Ambil top 10 jenis pelanggaran paling sering terjadi
       $hitung = DB::table('pelanggarans')
    ->select('jenis', 'konsekuensi', 'poin', DB::raw('COUNT(*) as totals'))
    ->groupBy('jenis', 'konsekuensi', 'poin')
    ->orderByDesc('totals')
    ->limit(10)
    ->get();



        // Kirim data ke view dashboard (ganti dengan folder view sesuai struktur kamu)
        return view('admin.dashboard', compact('jmlSiswas', 'jmlPelanggars', 'pelanggars', 'hitung'));
    }
}
