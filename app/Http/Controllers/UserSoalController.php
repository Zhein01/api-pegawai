<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Lamaran;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Lowongan;
use App\Models\Soal;
class UserSoalController extends Controller
{

    public function getSoal(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'lamaran_id' => 'required',
            ]);

            $lamaran = Lamaran::where('id', $request->lamaran_id)
                            ->where('user_id', $request->user_id)
                            ->first();

            if (!$lamaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lamaran tidak ditemukan untuk user ini.',
                ], Response::HTTP_NOT_FOUND);
            }

            $lowongan = $lamaran->lowongan;

            if (!$lowongan || $lowongan->batch_soal_id === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lowongan tidak memiliki batch soal.',
                ], Response::HTTP_NOT_FOUND);
            }

            $soals = Soal::where('batch_soal_id', $lowongan->batch_soal_id)->get();

            return response()->json([
                'success' => true,
                'message' => 'Soal berhasil diambil.',
                'data' => $soals,
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil soal: ' . $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function isSend(Request $request){
        try{
            $request->validate([
                'lamaran_id' => 'required'
            ]);

            $isSend = Hasil::where('lamaran_id', $request->lamaran_id)->exists();

            return response()->json([
                'success' => $isSend,
                'message' => 'Successful',
            ], Response::HTTP_OK);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function sendJawaban(Request $request){
        try{
            $request->validate([
                'lamaran_id' => 'required',
                'jum_benar' => 'required',
            ]);

            $lamaran = Lamaran::find($request->lamaran_id);
            $lowongan = Lowongan::find($lamaran->lowongan_id);

            $soal = Soal::where('batch_soal_id', $lowongan->batch_soal_id)->count();
            $skor = ($request->jum_benar / $soal) *  100;

            $status = "gagal";
            if($skor >= 75){
                $status = "lulus";
            }

            Hasil::create([
                'lamaran_id' => $request->lamaran_id, 
                'skor' => $skor,
                'status' => $status 
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Successfull',
            ], Response::HTTP_CREATED);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim jawaban: ' . $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
