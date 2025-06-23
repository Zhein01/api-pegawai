<?php

namespace App\Http\Controllers;

use App\Models\BatchSoal;
use App\Models\Hasil;
use App\Models\Lamaran;
use App\Models\Lowongan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PhpParser\Node\Expr;

class AdminLowonganController extends Controller
{
    public function getLowongan(){
        try{
            $dataLowongan = Lowongan::all();
            return response()->json([
                'success' => true,
                'message' => 'SSuccesfull to get data lowongan',
                'data' => $dataLowongan
            ]);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function addLowongan(Request $request){
        try{
            $request->validate([
                'nama' => 'required',
                'perusahaan' => 'required',
                'lokasi' => 'required',
                'periode' => 'required',
                'deskripsi' => 'required',
                'kualifikasi' => 'required',
            ]);

            Lowongan::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Successfull',
            ], Response::HTTP_CREATED);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function editLowongan(Request $request){
        try{
            $request->validate([
                'id' => 'required',
                'nama' => 'required',
                'perusahaan' => 'required',
                'lokasi' => 'required',
                'periode' => 'required',
                'deskripsi' => 'required',
                'kualifikasi' => 'required',
            ]);

            $dataLowongan = Lowongan::find($request->id);

            if($dataLowongan){
                
                $dataLowongan->nama = $request->nama;
                $dataLowongan->perusahaan = $request->perusahaan;
                $dataLowongan->lokasi = $request->lokasi;
                $dataLowongan->periode = $request->periode;
                $dataLowongan->deskripsi = $request->deskripsi;
                $dataLowongan->kualifikasi = $request->kualifikasi;
                $dataLowongan->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                ], Response::HTTP_CREATED);
            } 

            return response()->json([
                'success' => false,
                'message' => 'Lowongan not found with id: '.$request->id,
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteLowongan(Request $request){
        try{
            $request->validate([
                'id' => 'required',
            ]);

            $dataLowongan = Lowongan::find($request->id);
            if($dataLowongan){
                $dataLowongan->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                ], Response::HTTP_CREATED);
            } 

            return response()->json([
                'success' => false,
                'message' => 'Lowongan not found with id: '.$request->id,
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    
    public function accLamaran(Request $request){
        try{
            $request->validate([
                'id' => 'required',
            ]);

            $dataLamaraan = Lamaran::find($request->id);
            if($dataLamaraan){
                $dataLamaraan->status = "acc";
                $dataLamaraan->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                ], Response::HTTP_CREATED);
            } 

            return response()->json([
                'success' => false,
                'message' => 'lamaran not found with id: '.$request->id,
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getBatchSoal(){
        try{
            $batchSoal = BatchSoal::all();
            return response()->json([
                'success' => true,
                'message' => 'Succesfull to get data batch soal',
                'data' => $batchSoal
            ]);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function mulaiSeleksi(Request $request){
        try{
            $request->validate([
                'lowongan_id' => 'required',
                'batch_soal_id' => 'required'
            ]);

            $lowongan = Lowongan::find($request->lowongan_id);
            if($lowongan){
                $batchSoal = BatchSoal::find($request->batch_soal_id);
                if($batchSoal){
                    $lowongan->batch_soal_id = $request->batch_soal_id;
                    $lowongan->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Successfull',
                    ], Response::HTTP_CREATED);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Batch soal not found with id: '.$request->batch_soal_id,
                    ], Response::HTTP_BAD_REQUEST);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Lowongan not found with id: '.$request->lowongan_id,
                ], Response::HTTP_BAD_REQUEST);
            }
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function lihatHasil(Request $request){
        try{
            $request->validate([
                'lowongan_id' => 'required'
            ]);
            $lamarans = Lamaran::where('lowongan_id', $request->lowongan_id)->get();
            $lamaranIds = $lamarans->pluck('id');
            $hasilList = Hasil::with('lamaran')->whereIn('lamaran_id', $lamaranIds)->get();

            $dataHasil = $hasilList->map(function ($hasil) {
                return [
                    'nama' => $hasil->lamaran->nama ?? 'Tidak ada nama',
                    'skor' => $hasil->skor,
                    'status' => $hasil->status
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendapatkan semua hasil',
                'data' => $dataHasil
            ]);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function isLowonganBerakhir(Request $request){
        try{
            $request->validate([
                'lowongan_id' => 'required'
            ]);

            $isLowonganBerakhir = false;
            $lowongan = Lowongan::find($request->lowongan_id);
            if($lowongan->selesai){
                $isLowonganBerakhir = true;
            }
            return response()->json([
                'success' => $isLowonganBerakhir,
                'message' => 'Successful',
            ], Response::HTTP_OK);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function akhiriLowongan(Request $request){
        try{
            $request->validate([
                'lowongan_id' => 'required'
            ]);

            $lowongan = Lowongan::find($request->lowongan_id);
            $lowongan->selesai = true;
            $lowongan->save();

            return response()->json([
                'success' => true,
                'message' => 'Successfull',
            ], Response::HTTP_CREATED);

        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
