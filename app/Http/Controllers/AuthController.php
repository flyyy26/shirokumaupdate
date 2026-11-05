<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Helpers\LogHelper;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // display registration form for siswa
    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Log dipindahkan ke sini agar mencatat login yang BERHASIL
            LogHelper::log(
                'Login',
                'Login ke sistem'
            );

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Email atau password salah!');
    }

   public function register(Request $request)
    {
        try {
            // Validasi dasar
            $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|confirmed|min:6',
                'tempat_lahir' => 'required|string',
                'tanggal_lahir' => 'required|date_format:d/m/Y',
                'jenis_kelamin' => 'required|in:L,P',
                'agama' => 'required|string|max:50',
                'alamat' => 'nullable|string',
                'no_hp' => 'required|string|max:20',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',// 10MB max
            ]);
    
            // Cek apakah ada file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                // Validasi tambahan untuk file
                if (!$file->isValid()) {
                    return back()
                        ->withInput()
                        ->with('error', 'File foto tidak valid. Silakan upload ulang.');
                }
                
                if ($file->getSize() > 10 * 1024 * 1024) {
                    return back()
                        ->withInput()
                        ->with('error', 'Ukuran foto maksimal 10MB');
                }
            }
    
            // Create user
            $userData = [
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'siswa',
            ];
            
            $user = User::create($userData);
    
            // Prepare siswa data
            $siswaData = [
                'nama_lengkap' => $request->nama_lengkap,
                'nama_lengkap_katakana' => $request->nama_lengkap_katakana,
                'nama_panggilan' => $request->nama_panggilan,
                'nama_panggilan_katakana' => $request->nama_panggilan_katakana,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => Carbon::createFromFormat('d/m/Y', $request->tanggal_lahir)->format('Y-m-d'),
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'user_id' => $user->id,
            ];
    
            // Handle foto upload dengan try-catch
            if ($request->hasFile('foto')) {
                try {
                    $siswaData['foto'] = $request->file('foto')->store('siswa', 'public');
                } catch (\Exception $e) {
                    \Log::error('Gagal upload foto: ' . $e->getMessage());
                    // Tetap lanjutkan registrasi meski foto gagal upload
                }
            }
    
            // Set status awal
            $firstStatus = \App\Models\StudentStatus::orderBy('urutan', 'asc')->first();
            if ($firstStatus) {
                $siswaData['student_status_id'] = $firstStatus->id;
            }
    
            Siswa::create($siswaData);
    
            Auth::login($user);
    
            LogHelper::log('Register', 'Registrasi akun baru dengan email: ' . $user->email);
    
            return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Registrasi error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
        }
    }

    public function logout()
    {
        Auth::logout();
        LogHelper::log(
            'Logout',
            'Logout dari sistem'
        );
        return redirect('/login');
    }

    /**
     * Fitur Login sebagai Siswa (Impersonation)
     */
    public function loginAsSiswa(Siswa $siswa)
    {
        $user = $siswa->user;

        if (!$user) {
            return back()->with('error', 'Akun user tidak ditemukan untuk siswa ini.');
        }

        // Simpan ID admin ke session sebelum pindah agar bisa kembali
        session(['impersonate' => Auth::id()]);

        Auth::login($user);

        LogHelper::log('Impersonation', 'Admin login sebagai siswa: ' . $siswa->nama_lengkap);

        return redirect('/dashboard')->with('success', 'Berhasil login sebagai ' . $siswa->nama_lengkap);
    }

    /**
     * Kembali ke akun Admin dari mode Impersonation
     */
    public function backToAdmin()
    {
        $adminId = session('impersonate');

        if (!$adminId) {
            return redirect('/dashboard');
        }

        $admin = User::find($adminId);
        
        if ($admin) {
            Auth::login($admin);
            session()->forget('impersonate');
            return redirect()->route('siswa.index')->with('success', 'Kembali ke akun Admin');
        }

        return redirect('/login');
    }

    /**
     * Menampilkan halaman pengaturan profil
     */
    public function showSettings()
    {
        return view('settings', ['user' => Auth::user()]);
    }

    /**
     * Memperbarui pengaturan profil (nama, email, password)
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $user->email = $request->email;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Password saat ini tidak cocok.');
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        LogHelper::log('Update Settings', 'Memperbarui profil user: ' . $user->email);

        return back()->with('success', 'Pengaturan profil berhasil diperbarui.');
    }
}