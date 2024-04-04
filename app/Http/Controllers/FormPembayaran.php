<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use App\Model\{Pembayaran, Users};

class FormPembayaran extends Controller
{

    public function __construct()
    {
        session_start();
        if(\Session::get('user') == null) {
            return redirect('/login');
        }
    }

    public function index()
    {
        return view('form_pembayaran_bonus');
    }

    public function create()
    {
        return view('add_form_pembayaran_bonus');
    }

    public function getData()
    {
        $data       = Pembayaran::select('uniq_code')->distinct()->get();
        $tampungData = [];
        foreach($data as $val) {
            
            if(\Session::get('user')->role == 'admin') {
                $action = '<a href="/form/edit/' . $val->uniq_code . '" class="btn btn-sm btn-primary">Edit</a>
                <a href="/form/view/' . $val->uniq_code . '" class="btn btn-sm btn-info">View</a>
                <a href="/form/delete-pembayaran-by-uniqe-code/' . $val->uniq_code . '" class="btn btn-sm btn-danger">Delete</a>';
            }else{
                $action = '<a href="/form/view/' . $val->uniq_code . '" class="btn btn-sm btn-info">View</a>';
            }
            $tampungData[] = [
                'no'        => count($tampungData) + 1,
                'uniq_code' => $val->uniq_code,
                'action'    => $action
            ];
        }

        return response()->json($tampungData);
    }

    public function edit($uniqueCode)
    {
        $data = Pembayaran::where('uniq_code', $uniqueCode)->get();
        return view('edit_pembayaran_bonus', ['data' => $data]);
    }

    public function view($uniqueCode)
    {
        $data = Pembayaran::where('uniq_code', $uniqueCode)->get();
        return view('view_pembayaran_bonus', ['data' => $data]);
    }

    public function update(Request $request, $uniqueCode)
    {
        $id             = $request->post('id');
        $totalBonus     = $request->post('totalBonus');
        $percentages    = $request->post('percentages');
        $bonusPerPerson = $request->post('bonusPerPerson');

        foreach ($percentages as $key => $val) {
            $checkData      = Pembayaran::where(['id' => @$id[$key], 'uniq_code' => $uniqueCode])->first(); 
            if($checkData) {
                $dataUpdate = array(
                    'name'       => 'Buruh ' . ($key + 1),
                    'total_bonus'=> $totalBonus,
                    'persentase' => $val,
                    'pembayaran' => @$bonusPerPerson[$key],
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                // print_r($dataUpdate);
                $result = Pembayaran::where('id', @$id[$key])->update($dataUpdate);
            }else{
                $dataInsert = array(
                    'uniq_code'  => $uniqueCode,
                    'name'       => 'Buruh ' . ($key + 1),
                    'total_bonus'=> $totalBonus,
                    'persentase' => $val,
                    'pembayaran' => @$bonusPerPerson[$key],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                // print_r($dataInsert);
                $result = Pembayaran::insert($dataInsert);
            }
        }

        try {
            if($result) {
                $response = array(
                    'code'   => 200,
                    'status' => 'success',
                    'message' => 'Data Berhasil Diupdate',
                    'data' => []
                );
                return response()->json($response, 200);
            }else{
                $response = array( 
                    'code'   => 400,
                    'status' => 'error',
                    'message' => 'Data Gagal Diupdate',
                    'data' => []
                );
                return response()->json($response, 400);
            }
        } catch (\Exception $e) {
            $response = array(
                'code'   => 500,
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            );
            return response()->json($response, 500);
        }
    }

    public function store(Request $request)
    {
        $totalBonus     = $request->post('totalBonus');
        $percentages    = $request->post('percentages');
        $bonusPerPerson = $request->post('bonusPerPerson');
        $uniqueCode     = Str::random(10);
        foreach ($percentages as $key => $percentage) {
            // print_r($bonusPerPerson[$key]);
            // echo 'Buruh ' . ($key + 1) . ' mendapat bonus ' . $bonusPerPerson[$key] . '<br>';
            $data = array(
                'uniq_code'  => $uniqueCode,
                'name'       => 'Buruh ' . ($key + 1),
                'total_bonus'=> $totalBonus,
                'persentase' => $percentage,
                'pembayaran' => $bonusPerPerson[$key],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $result = Pembayaran::insert($data);
        }

        try {
            if($result) {
                $response = array(
                    'code'   => 200,
                    'status' => 'success',
                    'message' => 'Data Berhasil Disimpan',
                    'data' => $data
                );
                return response()->json($response, 200);
            }else{
                $response = array( 
                    'code'   => 400,
                    'status' => 'error',
                    'message' => 'Data Gagal Disimpan',
                    'data' => $data
                );
                return response()->json($response, 400);
            }
        } catch (\Exception $e) {
            $response = array(
                'code'   => 500,
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => []
            );
            return response()->json($response, 500);
        }
    }

    public function deletePembayaranById(Request $request) 
    {
        $uniqueCode = $request->post('uniqueCode');
        $id         = $request->post('id');
        $checkId    = Pembayaran::where(['id' => $id, 'uniq_code' => $request->post('uniqueCode')]);
        if($checkId->count() > 0) {
            $result = $checkId->delete();
            if($result) {
                $response = array(
                    'code'   => 200,
                    'status' => 'success',
                    'message' => 'Data Berhasil Dihapus',
                    'data' => []
                );
                return response()->json($response, 200);
            }else{
                $response = array( 
                    'code'   => 400,
                    'status' => 'error',
                    'message' => 'Data Gagal Dihapus',
                    'data' => []
                );
                return response()->json($response, 400);
            }
        }
    }

    public function deletePembayaranByUniqeCode(Request $request, $uniqueCode)
    {
        $result = Pembayaran::where('uniq_code', $uniqueCode)->delete();
        if($result) {
            $response = array(
                'code'   => 200,
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus',
                'data' => []
            );
            return response()->json($response, 200);
        }else{
            $response = array( 
                'code'   => 400,
                'status' => 'error',
                'message' => 'Data Gagal Dihapus',
                'data' => []
            );
            return response()->json($response, 400);
        }
    }
}
