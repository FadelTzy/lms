<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\pembelajaran;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Matakuliah;
use App\Models\User;
class MateriController extends Controller
{
    public function materihapus($id)
    {
        $data = Materi::where('id', $id)->delete();
        if ($data) {
            return 'success';
        }
    }
    public function materiupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' => ['required', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
        $data = Materi::where('id', $request->id)->first();

        $data->nama_materi = $request->judul;
        $data->deskripsi = $request->keterangan;

        $data->save();

        return 'success';
    }
    public function materi($id)
    {
        $user = pembelajaran::with('oMatkul')->where('id', $id)->first();
        if (request()->ajax()) {
            return Datatables::of(Materi::where('id_pembelajaran',$id)->get())
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    $dataj = json_encode($data);
                    $btn =
                        "<ul class='list-inline mb-0'>
                <li class='list-inline-item'>
                <button type='button' data-toggle='modal' onclick='staffupd(" .
                        $dataj .
                        ")'   class='btn btn-success btn-xs mb-1'>Edit</button>
                </li>
                    <li class='list-inline-item'>
                    <button type='button'  onclick='staffdel(" .
                        $data->id .
                        ")'   class='btn btn-danger btn-xs mb-1'>Hapus</button>
                    </li>
                 
                </ul>";
                    return $btn;
                })
                
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('admin.materi', compact( 'user'));
    }
    public function materistore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pembelajaran' => ['required', 'string', 'max:255'],
            'nama_mk' => ['required', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
        $data = Materi::create([
            'nama_materi' => $request->judul,
            'id_pembelajaran' => $request->id_pembelajaran,
            'kode_mk' => $request->nama_mk,
            'deskripsi' => $request->keterangan,
        ]);

        if ($data) {
            return 'success';
        }
    }
}
