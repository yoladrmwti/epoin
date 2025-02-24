<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(): View
    {
        // Retrieve data from the database with pagination
        $siswas = DB::table('siswas')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('siswas.*', 'users.name', 'users.email')
            ->when(request('cari'), function ($query) {
                return $this->search(request('cari'), $query);
            })
            ->paginate(10);

        return view('admin.siswa.index', compact('siswas'));
    }

    public function create(): View
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nis' => 'required|numeric',
            'tingkatan' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'hp' => 'required|numeric'
        ]);

        // Handle image upload
        $image = $request->file('image');
        $imagePath = $image->storeAs('public/siswas', $image->hashName());

        // Insert user account
        $id_akun = $this->insertAccount($request->name, $request->email, $request->password);

        // Create siswa record
        Siswa::create([
            'id_user' => $id_akun,
            'image' => $image->hashName(),
            'nis' => $request->nis,
            'tingkatan' => $request->tingkatan,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'hp' => $request->hp,
            'status' => 1
        ]);

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function insertAccount(string $name, string $email, string $password)
    {
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'usertype' => 'siswa'
        ]);

        return DB::table('users')->where('email', $email)->value('id');
    }

    public function show(string $id): View
    {
        // Retrieve siswa data based on ID
        $siswa = DB::table('siswas')
            ->join('users', 'siswas.id_user', '=', 'users.id')
            ->select('siswas.*', 'users.name', 'users.email')
            ->where('siswas.id', $id)
            ->first();

        return view('admin.siswa.show', compact('siswa'));
    }

    public function search(string $cari, $query)
    {
        return $query->where('users.name', 'like', '%' . $cari . '%')
            ->orWhere('siswas.nis', 'like', '%' . $cari . '%')
            ->orWhere('users.email', 'like', '%' . $cari . '%');
    }

    public function edit($id): View
    {
        // Retrieve the siswa record
        $siswa = Siswa::findOrFail($id);

        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:250',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'nis' => 'required|numeric',
            'tingkatan' => 'required',
            'jurusan' => 'required',
            'kelas' => 'required',
            'hp' => 'required|numeric',
            'status' => 'required',
        ]);

        // Retrieve the siswa record
        $datas = Siswa::findOrFail($id);
        $this->editAccount($request->name, $datas->id_user);

        // Handle image update if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/siswas', $image->hashName());
            Storage::delete('public/siswas' . $datas->image);
            $datas->image = $image->hashName();
        }

        // Update the siswa record
        $datas->update([
            'nis' => $request->nis,
            'tingkatan' => $request->tingkatan,
            'jurusan' => $request->jurusan,
            'kelas' => $request->kelas,
            'hp' => $request->hp,
            'status' => $request->status
        ]);

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function editAccount(string $name, string $id)
    {
        // Retrieve the user associated with siswa
        $user = User::findOrFail($id);
        $user->update(['name' => $name]);
    }

    public function destroy($id): RedirectResponse
    {
        // Delete the related user and siswa data
        $this->destroyUser($id);
        $siswa = Siswa::findOrFail($id);

        // Delete the image
        Storage::delete('public/siswas/' . $siswa->image);

        // Delete the siswa record
        $siswa->delete();

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function destroyUser(string $id)
    {
        // Retrieve the user associated with the siswa
        $siswa = Siswa::findOrFail($id);
        $user = User::findOrFail($siswa->id_user);
        $user->delete();
    }
}
