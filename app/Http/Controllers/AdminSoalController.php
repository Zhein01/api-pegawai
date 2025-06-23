<?php

namespace App\Http\Controllers;

use App\Models\BatchSoal;
use App\Models\Lowongan;
use App\Models\Soal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminSoalController extends Controller
{
    public function getBatchSoal(){
        try{
            $dataBatchSoal = BatchSoal::all();
            return response()->json([
                'success' => true,
                'message' => 'Succesfull to get data batch soal',
                'data' => $dataBatchSoal
            ]);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getNameBatchByLowongan(Request $request){
        try{
            $request->validate([
                'id' => 'required'
            ]);

            $lowongan = Lowongan::find($request->id);
            if($lowongan){

                $batchSoal = BatchSoal::find($lowongan->batch_soal_id);
                if($batchSoal){

                    return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                    'data' => $batchSoal
                ], Response::HTTP_OK);
                }else{

                    return response()->json([
                        'success' => false,
                        'message' => 'Batch soal not found with id: '.$lowongan->batch_soal_id,
                    ], Response::HTTP_BAD_REQUEST);
                }
            }else{

                 return response()->json([
                    'success' => false,
                    'message' => 'Lowongan not found with id: '.$request->id,
                ], Response::HTTP_BAD_REQUEST);
            }
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function addBatchSoal(Request $request){
        try{
            $request->validate([
                'nama' => 'required',
            ]);

            BatchSoal::create($request->all());

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

    public function editBatchSoal(Request $request){
        try{
            $request->validate([
                'id' => 'required',
                'nama' => 'required',
            ]);

            $dataBatchSoal = BatchSoal::find($request->id);

            if($dataBatchSoal){
                
                $dataBatchSoal->nama = $request->nama;
                $dataBatchSoal->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                ], Response::HTTP_CREATED);
            } 

            return response()->json([
                'success' => false,
                'message' => 'Batch soal not found with id: '.$request->id,
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteBatchSoal(Request $request){
        try{
            $request->validate([
                'id' => 'required',
            ]);

            $dataBatchSoal = BatchSoal::find($request->id);
            if($dataBatchSoal){
                
                $dataBatchSoal->delete();

                $dataSoal = Soal::where('batch_soal_id', $request->id)->get();
                foreach ($dataSoal as $soal) {
                    $soal->delete();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                ], Response::HTTP_CREATED);
            } 

            return response()->json([
                'success' => false,
                'message' => 'Batch soal not found with id: '.$request->id,
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getSoal(Request $request){
        $request->validate([
            'batch_soal_id' => 'required',
        ]);
        try{
            $dataSoal = Soal::where('batch_soal_id', $request->batch_soal_id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Succesfull to get data soal',
                'data' => $dataSoal
            ]);
        } catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function addSoal(Request $request){
        try{
            $request->validate([
                'batch_soal_id' => 'required',
                'soal' => 'required',
                'pil1' => 'required',
                'pil2' => 'required',
                'pil3' => 'required',
                'pil4' => 'required',
                'jawaban' => 'required',
            ]);

            Soal::create($request->all());

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

    public function editSoal(Request $request){
        try{
            $request->validate([
                'id' => 'required',
                'soal' => 'required',
                'pil1' => 'required',
                'pil2' => 'required',
                'pil3' => 'required',
                'pil4' => 'required',
                'jawaban' => 'required',
            ]);

            $dataSoal = Soal::find($request->id);

            if($dataSoal){
                $dataSoal->soal = $request->soal;
                $dataSoal->pil1 = $request->pil1;
                $dataSoal->pil2 = $request->pil2;
                $dataSoal->pil3 = $request->pil3;
                $dataSoal->pil4 = $request->pil4;
                $dataSoal->jawaban = $request->jawaban;
                $dataSoal->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                ], Response::HTTP_CREATED);
            } 

            return response()->json([
                'success' => false,
                'message' => 'Soal not found with id: '.$request->id,
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteSoal(Request $request){
        try{
            $request->validate([
                'id' => 'required',
            ]);

            $Soal = Soal::find($request->id);
            if($Soal){
                $Soal->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                ], Response::HTTP_CREATED);
            } 

            return response()->json([
                'success' => false,
                'message' => 'Soal not found with id: '.$request->id,
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}