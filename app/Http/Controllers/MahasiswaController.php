<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    function index()
    {
        $mahasiswa = Mahasiswa::all();
        return response()->json([
            'success' => true,
            'message' => 'Success fetching data mahasiswa',
            'data' => $mahasiswa
        ], 200);
    }

    function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npm' => 'required|unique:mahasiswa',
            'nama' => 'required',
            'angkatan' => 'required',
            'ipk' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        } else {
            $mahasiswa = Mahasiswa::create([
                'npm' => $request->npm,
                'nama' => $request->nama,
                'angkatan' => $request->angkatan,
                'ipk' => $request->ipk
            ]);

            if ($mahasiswa) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mahasiswa created successfully',
                    'data' => $mahasiswa
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create mahasiswa',
                    'data' => null
                ], 500);
            }
        }
    }

    function read($npm)
    {
        $mahasiswa = Mahasiswa::where('npm', $npm)->first();

        if ($mahasiswa) {
            return response()->json([
                'success' => true,
                'message' => 'Success fetching data mahasiswa',
                'data' => $mahasiswa
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa not found',
                'data' => null
            ], 404);
        }
    }

    function update(Request $request, $npm)
    {
        // sometimes|required artinya jika ada field yang dikirimkan, maka field tersebut harus diisi
        // jika tidak ada field yang dikirimkan, maka tidak perlu diisi
        $validator = Validator::make($request->all(), [
            'npm' => 'sometimes',
            'nama' => 'sometimes',
            'angkatan' => 'sometimes',
            'ipk' => 'sometimes|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 400);
        } else {
            $mahasiswa = Mahasiswa::where('npm', $npm)->first();

            if ($mahasiswa) {
                // Menggunakan array_filter untuk menghapus field yang null atau kosong
                $fieldsToUpdate = array_filter($request->only([
                    'npm', 'nama', 'angkatan', 'ipk'
                ]), function ($value) {
                    return $value !== null && $value !== '';
                });
                $mahasiswa->update($fieldsToUpdate);

                return response()->json([
                    'success' => true,
                    'message' => 'Mahasiswa updated successfully',
                    'data' => $mahasiswa
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Mahasiswa not found',
                    'data' => null
                ], 404);
            }
        }
    }

    function delete($npm)
    {
        $mahasiswa = Mahasiswa::where('npm', $npm)->first();

        if ($mahasiswa) {
            $mahasiswa->delete();
            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa deleted successfully',
                'data' => null
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa not found',
                'data' => null
            ], 404);
        }
    }
}