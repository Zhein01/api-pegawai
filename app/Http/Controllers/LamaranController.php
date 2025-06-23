<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use Illuminate\Http\Request;
use App\Models\Lamaran; // Sesuaikan dengan model yang kamu gunakan
use Exception;
use Illuminate\Http\Response;

class LamaranController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'cv' => 'required|file|mimes:pdf',
            'user_id' => 'required|integer',
            'lowongan_id' => 'required|integer',
            'nama' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required|string',
            'pendidikan' => 'required|string',
        ]);

        // Logika untuk menyimpan lamaran
        $cvPath = $request->file('cv')->store('cv', 'public');

        // Simpan data lamaran
        Lamaran::create([
            'user_id' => $request->user_id,
            'lowongan_id' => $request->lowongan_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'pendidikan' => $request->pendidikan,
            'cv' => $cvPath,
        ]);

        return response()->json(['message' => 'Lamaran berhasil dikirim']);
    }
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
    
        $lamaran = Lamaran::with('lowongan')
        ->where('user_id', $userId)
        ->get();
    
    
        return response()->json([
            'success' => true,
            'data' => $lamaran
        ]);
    }

    public function getLamaranByUser($userId)
{
    $lamaran = Lamaran::where('user_id', $userId)->get();
    return response()->json($lamaran);
}

public function getByUser($id)
{
    $lamarans = Lamaran::where('user_id', $id)->with(['lowongan'])->get();
    return response()->json($lamarans);

    $lamaran = Lamaran::with('lowongan')->where('user_id', $id)->get();
    return response()->json($lamaran);

}


public function cekLamaran(Request $request)
{
    $userId = $request->query('user_id');
    $lowonganId = $request->query('lowongan_id');

    if (!$userId || !$lowonganId) {
        return response()->json([
            'sudah_melamar' => false,
            'message' => 'Parameter tidak lengkap'
        ], 400);
    }

    $sudahMelamar = Lamaran::where('user_id', $userId)
                    ->where('lowongan_id', $lowonganId)
                    ->exists();

    return response()->json([
        'sudah_melamar' => $sudahMelamar
    ]);
}

public function getPendaftarByLowongan($id)
{
    $pendaftar = Lamaran::with('user')
        ->where('lowongan_id', $id)
        ->get();

    return response()->json([
        'success' => true,
        'data' => $pendaftar
    ]);
}


// LamaranController.php
public function getByLowongan($id)
{
    $pendaftar = \App\Models\Lamaran::with('user')
                  ->where('lowongan_id', $id)
                  ->get();

    return response()->json([
        'success' => true,
        'data' => $pendaftar
    ]);
}

    public function lihatHasilLamaran(Request $request){
        try{
            $request->validate([
                'lamaran_id' => 'required'
            ]);

            $hasil = Hasil::where('lamaran_id', $request->lamaran_id)->first();
            $dataHasil = [
                'nama' => $hasil->lamaran->nama,
                'skor' => $hasil->skor,
                'status' => $hasil->status,
            ];
            return response()->json([
                'success' => true,
                'message' => 'Successfull',
                'data' => $dataHasil
            ], Response::HTTP_OK);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
