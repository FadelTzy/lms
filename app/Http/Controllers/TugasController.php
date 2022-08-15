<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\pembelajaran;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Matakuliah;
use App\Models\User;
use App\Models\Text;
use App\Models\File;
use App\Models\Tugas;

class TugasController extends Controller
{
    public function materitugas($id)
    {
        $user = pembelajaran::with('oMatkul','oMateri')->where('id', $id)->first();
        if (request()->ajax()) {
            return Datatables::of(Tugas::with('oMateri')->where('id_materi',$id)->get())
                ->addIndexColumn()
                ->addColumn('aksi', function ($data) {
                    $dataj = json_encode($data);
                    $btn =
                        "<ul class='list-inline mb-0'>
                <li class='list-inline-item'>
                <button type='button' data-toggle='modal' onclick='staffupd(" .
                        $dataj .
                        ")'   class='btn btn-sm btn-success btn-xs mb-1'>Edit</button>
                </li>
                    <li class='list-inline-item'>
                    <button type='button'  onclick='staffdel(" .
                        $data->id .
                        ")'   class='btn btn-sm btn-danger btn-xs mb-1'>Hapus</button>
                    </li>
                    <li class='list-inline-item'>
                    <button type='button'  onclick='lihat(" .
                        $dataj .
                        ")'   class='btn btn-sm btn-primary btn-xs mb-1'>Lihat</button>
                    </li>
                </ul>";
                    return $btn;
                })
                
                ->addColumn('filenya', function ($data) {
                    $dataj = json_encode($data);
                    $btn =
                        "<ul class='list-inline mb-0'>
                <li class='list-inline-item'>
                <a type='button' target='_blank' href='".asset('file/tugas') . '/' . $data->file."'  class='btn btn-sm btn-info btn-xs mb-1'>Lihat File</a>
                </li>
                 
                </ul>";
                    return $btn;
                })
                ->rawColumns(['aksi','filenya'])
                ->make(true);
        }
        return view('admin.materi.tugas', compact( 'user'));
    }
    public function materitugasstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pembelajaran' => ['required', 'string', 'max:255'],
            'file' => 'max:2000',
            'judul' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
        if (request()->file('file')) {
            $gmbr = request()->file('file');

            $nama_file = str_replace(' ', '_', time() . '_' . $gmbr->getClientOriginalName());
            $tujuan_upload = 'file/tugas/';
            $gmbr->move($tujuan_upload, $nama_file);
        }
        $data = Tugas::create([
            'nama' => $request->judul,
            'file' => $nama_file ?? null,
            'id_materi' => $request->id_pembelajaran,
            'isi' =>  $request->isi,
        ]);

        if ($data) {
            return 'success';
        }
    }
    public function materitugasupdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            $data = ['status' => 'error', 'data' => $validator->errors()];
            return $data;
        }
        $data = Tugas::where('id', $request->id)->first();
        if (request()->file('file')) {
            $gmbr = request()->file('file');
            if ($data->file) {
                $path = '/file/tugas/' . $data->file;
                if (file_exists(public_path() . $path)) {
                    unlink(public_path() . $path);
                }
            }
            $nama_file = str_replace(' ', '_', time() . '_' . $gmbr->getClientOriginalName());
            $tujuan_upload = 'file/tugas/';
            $gmbr->move($tujuan_upload, $nama_file);

            $data->file = $nama_file;
        }
        $data->isi = $request->isi;
        $data->nama = $request->judul;

        $data->save();

        return 'success';
    }
    public function materitugashapus($id)
    {
        $data = Tugas::where('id', $id)->first();
        if ($data->isi) {
            $path = '/file/tugas/' . $data->isi;
            if (file_exists(public_path() . $path)) {
                unlink(public_path() . $path);
            }
        }
        $data->delete();
        if ($data) {
            return 'success';
        }
    }
}
