<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Billing;
use App\Models\Payment;
use App\Helpers\LogHelper;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaBillingController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // Tagihan Belum Bayar
        $tagihan = Billing::where('siswa_id', $siswa->id)
            ->where('status', 'belum_bayar')
            ->latest()
            ->get();

        // Riwayat Transaksi (Menunggu Verifikasi / Lunas)
        $riwayat = Billing::where('siswa_id', $siswa->id)
            ->whereIn('status', ['menunggu_verifikasi', 'lunas'])
            ->with('payment')
            ->latest()
            ->get();

        LogHelper::log('Lihat Pembayaran', 'Melihat halaman pembayaran');

        return view('siswa.tagihan', compact('tagihan', 'riwayat'));
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'nama_bank' => 'required|string',
            'nomor_rekening' => 'required|string',
            'bukti_pembayaran' => 'required|image|max:2048',
        ]);

        $billing = Billing::findOrFail($id);
        
        $path = $request->file('bukti_pembayaran')->store('payments', 'public');

        Payment::create([
            'billing_id' => $billing->id,
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'bukti_pembayaran' => $path,
        ]);

        $billing->update(['status' => 'menunggu_verifikasi']);

        LogHelper::log('Bayar Tagihan', 'Mengupload bukti pembayaran untuk tagihan: ' . $billing->judul);

        return back()->with('success', 'Pembayaran berhasil dikirim, menunggu verifikasi admin.');
    }

    public function print($id)
    {
        $billing = Billing::with(['siswa', 'payment'])->findOrFail($id);

        // Pastikan hanya pemilik tagihan atau admin yang bisa cetak
        if (Auth::user()->role !== 'admin' && $billing->siswa_id !== Auth::user()->siswa->id) {
            abort(403);
        }

        $pdf = Pdf::loadView('siswa.tagihan_pdf', compact('billing'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Invoice_' . $billing->id . '.pdf');
    }
}