<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordMuridController extends Controller
{
    public function showUsernameForm()
    {
        return view('auth.forgot-password-murid-username');
    }



    public function checkUsername(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'exists:users,username'],
        ], [
            'username.required' => 'Username harus diisi',
            'username.exists' => 'Username tidak ditemukan',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::where('username', $request->username)->first();

        // Jika pengguna adalah Murid
        if ($user->hasRole('murid')) {
            $murid = $user->murid;

            if (!$murid || !$murid->preferensi_terisi) {
                return back()->with('error', 'Anda belum mengisi pertanyaan keamanan. Silakan registrasi akun.');
            }

            $preferensi = $murid->preferensiPertanyaan;

            if (!$preferensi) {
                return back()->with('error', 'Data pertanyaan keamanan tidak ditemukan. Silakan registrasi akun.');
            }

            session(['forgot_password_username' => $request->username]);

            return view('auth.forgot-password-murid-questions', [
                'pertanyaan' => $preferensi->pertanyaan,
            ]);
        } 
        
        // Email Link
        else {
            // Cek apakah user adalah Mentor dan punya data mentor
            if ($user->hasRole('mentor') && $user->mentor) {
                $email = $user->mentor->email; // Ambil email dari tabel mentors
            } else {
                // Jika Admin atau role lain yang tidak memiliki email di database (sesuai file admin migrasi)
                return back()->with('error', 'Fitur reset password ini belum tersedia untuk akun Admin (Email tidak ditemukan).');
            }

            if (!$email) {
                return back()->with('error', 'Alamat email tidak ditemukan untuk akun ini.');
            }

            // Trik: Set email ke object user secara dinamis agar Token Generator & Notifikasi bisa membacanya
            // Ini tidak menyimpan ke DB users, hanya di memori saat request ini berjalan
            $user->email = $email;

            try {
                // 1. Buat Token Reset Password secara manual
                $token = Password::broker()->createToken($user);

                // 2. Kirim Notifikasi Reset Password
                // Method ini bawaan Laravel User Model (via trait CanResetPassword)
                $user->sendPasswordResetNotification($token);

                return back()->with('status', 'Tautan reset password telah dikirim ke email: ' . $email);
            
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengirim email reset password. Silakan coba lagi.');
            }
        }
    }

    /**
     * Verify answer dan tampilkan form reset password
     */
    public function verifyAnswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jawaban' => ['required', 'string'],
        ], [
            'jawaban.required' => 'Jawaban harus diisi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $username = session('forgot_password_username');

        if (!$username) {
            return redirect()->route('password.murid.request')
                ->with('error', 'Sesi telah berakhir. Silakan mulai dari awal.');
        }

        $user = User::where('username', $username)->first();
        $murid = $user->murid;
        $preferensi = $murid->preferensiPertanyaan;

        // Verify answer (case insensitive)
        $isCorrect = $preferensi->verifyAnswer($request->jawaban);

        if (!$isCorrect) {
            return back()->with('error', 'Jawaban tidak sesuai. Silakan coba lagi.');
        }

        // Store verification status in session
        session(['password_reset_verified' => true]);

        return view('auth.forgot-password-murid-reset');
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        if (!session('password_reset_verified')) {
            return redirect()->route('password.murid.request')
                ->with('error', 'Verifikasi gagal. Silakan mulai dari awal.');
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Password baru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $username = session('forgot_password_username');
        $user = User::where('username', $username)->first();

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear session
        session()->forget(['forgot_password_username', 'password_reset_verified']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }
}
