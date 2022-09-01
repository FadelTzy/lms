<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pembelajaran;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Matakuliah;
use App\Models\Materi;
use App\Models\User;
use App\Models\Text;
use App\Models\Video;
use App\Models\Tugas;
use App\Models\File;
class PembelajaranController extends Controller
{
    public function pembelajaranhapus($id)
    {
        $data = pembelajaran::where('id', $id)->delete();
        if ($data) {
           $m = Materi::where('id_pembelajaran',$id)->first();
           if ($m) {
            Text::where('id_materi',$m->id)->delete();
            Video::where('id_materi',$m->id)->delete();
            File::where('id_materi',$m->id)->delete();
            Tugas::where('id_materi',$m->id)->delete();
            $m->delete();
           }
            return 'success';
        }
    }
    public function pembelajaranupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dosen' => ['required', 'string', 'max:255'],
            'matkul' => ['required', 'string', 'max:255'],
            'hari' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
        $data = pembelajaran::where('id', $request->id)->first();

        
        $data->id_user = $request->dosen;
        $data->mitra = $request->mitra;
        $data->id_matkul = $request->matkul;
        $data->hari = $request->hari;
        $data->jam_awal = $request->awal;
        $data->jam_akhir = $request->akhir;
        $data->keterangan = $request->keterangan;

        $data->save();

        return 'success';
    }
    public function pembelajaran()
    {
        $matkul = Matakuliah::get();
        $user = User::where('role', 2)->get();
        if (request()->ajax()) {
            return Datatables::of(pembelajaran::with('oMitra', 'oDosen')->get())
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
                     <li class='list-inline-item'>
                    <a href='". url('admin/data-materi') . '/' . $data->id ."'   class='btn btn-primary btn-xs mb-1'>Materi</a>
                    </li>
                </ul>";
                    return $btn;
                })
                ->addColumn('pengampuhnya', function ($data) {
                    $btn = $data->oDosen->name;
                    return $btn;
                })
                ->addColumn('mitranya', function ($data) {
                    $btn = $data->oMitra->name;
                    return $btn;
                })
                ->addColumn('matkulnya', function ($data) {
                    $btn = $data->oMatkul->nama_mk;
                    return $btn;
                })
                ->addColumn('jadwalnya', function ($data) {
                    $btn = $data->hari . ' ' . $data->jam_awal . ' - ' . $data->jam_akhir;
                    return $btn;
                })
                ->addColumn('statusnya', function ($data) {
                    if ($data->status == 1) {
                        $btn = '<span class="badge badge-primary">Aktif</span>';
                    } else {
                        $btn = '<span class="badge badge-danger">Non Aktif</span>';
                    }
                    return $btn;
                })
                ->rawColumns(['aksi', 'mitranya', 'jadwalnya', 'statusnya', 'matkulnya', 'pengampuhnya', 'user'])
                ->make(true);
        }
        return view('admin.pembelajaran', compact('matkul', 'user'));
    }
    public function pembelajaranstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dosen' => ['required', 'string', 'max:255'],
            'matkul' => ['required', 'string', 'max:255'],
            'hari' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
        $data = pembelajaran::create([
            'id_user' => $request->dosen,
            'mitra' => $request->mitra,
            'id_matkul' => $request->matkul,
            'hari' => $request->hari,
            'jam_awal' => $request->awal,
            'jam_akhir' => $request->akhir,
            'keterangan' => $request->keterangan,
            'status' => 1,
        ]);

        if ($data) {
            return 'success';
        }
    }
}
