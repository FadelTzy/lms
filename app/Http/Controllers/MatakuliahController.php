<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Models\Materi;
use App\Models\pembelajaran;
use App\Models\Text;
use App\Models\Tugas;
use App\Models\Video;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
class MatakuliahController extends Controller
{
    public function matkulhapus($id)
    {
            $data = Matakuliah::where('id',$id)->delete();
            if ($data) {
                $pem = pembelajaran::where('id_matkul',$id)->first();
                if ($pem) {
                    $materi = Materi::where('id_pembelajaran',$pem->id)->first();
                    $pem->delete();
                    if ($materi) {
                        Text::where('id_materi',$materi->id)->delete();
                        Video::where('id_materi',$materi->id)->delete();
                        File::where('id_materi',$materi->id)->delete();
                        Tugas::where('id_materi',$materi->id)->delete();
                    $materi->delete();
                    }
                }
                return 'success';
            }
    }
    public function matkulstore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kode' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
         

        ]);
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
            $data =  Matakuliah::create([
                'kode_mk' => $request->kode,
                'nama_mk' => $request->nama,
     
            ]);
        
        if ($data) {
            return 'success';
        }
    }
    public function matkulupdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kode' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
         

        ]);
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
        $data = Matakuliah::where('id',$request->id)->first();
        $data->kode_mk = $request->kode;
        $data->nama_mk = $request->nama;
        $data->save();
        
        if ($data) {
            return 'success';
        }
    }
    public function index()
    {
        if (request()->ajax()) {
            return Datatables::of(Matakuliah::get())->addIndexColumn()->addColumn('aksi', function ($data) {
                $dataj = json_encode($data);
                $btn = "<ul class='list-inline mb-0'>
                <li class='list-inline-item'>
                <button type='button' data-toggle='modal' onclick='staffupd(" . $dataj . ")'   class='btn btn-success btn-xs mb-1'>Edit</button>
                </li>
                    <li class='list-inline-item'>
                        <button type='button'  onclick='staffdel(" . $data->id . ")'   class='btn btn-danger btn-xs mb-1'>Hapus</button>
                    </li>     
                </ul>";
                return $btn;
            })->rawColumns(['aksi'])->make(true);
        }
        return view('admin.matkul');
    }
}
