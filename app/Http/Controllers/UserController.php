<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validasi dan logika registrasi
        $validated = $request->validate([
            'nik' => 'required|unique:users,nik',
            'nama' => 'required',
            'alamat' => 'required',
            'jkl' => 'required',
            'no_hp' => 'required',
            'username' => 'required|string|unique:users,username',
            'password' => 'required',
        ]);
    
        // Proses registrasi dan simpan data
        $user = User::create([
            'nik' => $validated['nik'],
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'jkl' => $validated['jkl'],
            'no_hp' => $validated['no_hp'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil',
            'data' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        $user = User::where('username', $request->username)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        }
    
        $token = $user->createToken('YourAppName')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ]
        ]);
    } 

    public function getProfil(Request $request){
        try{
            $request->validate([
                'id' => 'required',
            ]);

            $dataUser = User::find($request->id);
            if($dataUser){

                return response()->json([
                    'success' => true,
                    'message' => 'Successfull',
                    'data' => $dataUser
                ], Response::HTTP_OK);
            } 

            return response()->json([
                'success' => false,
                'message' => 'user not found with id: '.$request->id,
            ], Response::HTTP_BAD_REQUEST);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    
    public function updateProfil(Request $request){
        try{
            $request->validate([
                'id' => 'required',
                'nik' => 'required',
                'nama' => 'required',
                'alamat' => 'required',
                'jkl' => 'required',
                'no_hp' => 'required',
            ]);

            $user = User::find($request->id);
            if(!$user) {
                return response()->json([
                    'success' => false, 
                    'message' => 'User tidak ditemukan dengan id '.$request->id
                ], Response::HTTP_BAD_REQUEST);
            }

            $user->nik = $request->nik;
            $user->nama = $request->nama;
            $user->alamat = $request->alamat;
            $user->jkl = $request->jkl;
            $user->no_hp = $request->no_hp;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            return response()->json([
                'success' => true, 
                'message' => 'Profil berhasil diperbarui'
                ], Response::HTTP_CREATED);
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed: ' . $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}