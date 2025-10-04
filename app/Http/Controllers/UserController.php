<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showLoginForm() {
        return view('admin.user.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah! Silahkan masukkan data yang sesuai',
        ])->onlyInput('username');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function index() {
        $users = User::orderBy('updated_at', 'desc')->get();
        return view('admin.user.index', compact('users'));
    }

    public function create() {
        return view('admin.user.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'username' => 'required|string|max:20|unique:users,username',
            'password' => 'required|min:8',
            'nama' => 'required|string|max:100',
            'role' => 'required',
            'email' => 'email|max:100|unique:users,email',
            'no_telepon' => 'string|max:15|regex:/^[0-9+\-\s()]+$/',
            'status' => '',
            'tahun_mulai' => '',
            'tahun_selesai' => ''
        ], [
            'username.unique' => 'Username sudah digunakan',
            'password.min' => 'Password minimal 8 karakter',
            'email.email' => 'Format email tidak valid',
        ]);

        User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'nama' => $validated['nama'],
            'role' => $validated['role'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'],
            'status' => $validated['status'],
            'tahun_mulai' => $validated['tahun_mulai'],
            'tahun_selesai' => $validated['tahun_selesai']
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit($username) {
        $user = User::findOrFail($username);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $username) {
        $validated = $request->validate([
            'password' => 'nullable|min:8',
            'nama' => 'required|string|max:100',
            'role' => 'required',
            'email' => 'nullable|email|max:100|unique:users,email',
            'no_telepon' => 'nullable|string|max:15|regex:/^[0-9+\-\s()]+$/',
            'status' => 'nullable',
            'tahun_mulai' => 'nullable',
            'tahun_selesai' => 'nullable'
        ], [
            'password.min' => 'Password minimal 8 karakter',
            'email.email' => 'Format email tidak valid',
        ]);

        $data = [
            'nama' => $validated['nama'],
            'role' => $validated['role'],
            'no_telepon' => $validated['no_telepon'],
            'status' => $validated['status'],
            'tahun_mulai' => $validated['tahun_mulai'],
            'tahun_selesai' => $validated['tahun_selesai']
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->Filled('email')) {
            $data['email'] = $validated['email'];
        }

        $user = User::findOrFail($username);
        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($username) {
        $user = User::findOrFail($username);

        if ($user->username === auth()->user()->username) {
            return redirect()->back()->withErrors([
                'error' => 'Tidak dapat menghapus akun sendiri.'
            ]);
        }

        if ($user->prediksi()->exists()) {
            return redirect()->back()->withErrors([
                'error' => 'User ini masih memiliki data prediksi, tidak dapat dihapus.'
            ]);
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
