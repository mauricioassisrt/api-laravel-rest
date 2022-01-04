<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as Image;

class MasterApiContoller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index()
    {
        $data = $this->model->all();

        return response()->json($data);
    }


    public function store(Request $request)
    {
        try {
            $this->validate($request, $this->model->rules());
            $dataForm = $request->all();

            // if ($request->hasFile('$this->upload') && $request->file('$this->upload')->isValid()) {
            //     $extension = $request->image->extension();
            //     $nome = uniqid(date('His'));
            //     $nameFile = "{$nome}.{$extension}";
            //     $upload = Image::make($dataForm['$this->upload'])->resize(177, 236)->
            //     save(storage_path("app/public/{$this->paht}/$nameFile", 70));
            //     if (!$upload) {
            //         return response()->json(['error' => 'Falha ao fazer upload', 500]);
            //     } else {
            //         $dataForm['$this->upload'] = $nameFile;
            //     }
            // }

            $data = $this->model->create($dataForm);
            return response()->json($data, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 500);
        }
    }



    public function show($id)
    {
        try {

            if (!$data = $this->model->find($id)) {
                return response()->json(["error" => "não existe esse registro para exibir "], 404);
            } else {
                return response()->json($data);
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            if (!$data = $this->model->find($id)) {
                return response()->json(["error" => "não existe esse registro para exibir "], 404);
            }

            $this->validate($request, $this->model->rules());
            $dataForm = $request->all();

            // if ($request->hasFile('$this->upload') && $request->file('$this->upload')->isValid()) {
            //   if ($data->image) {
            //     Storage::disk('public')->delete('clientes/$data->image');
            //  }
            //     $extension = $request->image->extension();
            //     $nome = uniqid(date('His'));
            //     $nameFile = "{$nome}.{$extension}";
            //     $upload = Image::make($dataForm['$this->upload'])->resize(177, 236)->
            //     save(storage_path("app/public/clientes/$nameFile", 70));
            //     if (!$upload) {
            //         return response()->json(['error' => 'Falha ao fazer upload', 500]);
            //     } else {
            //         $dataForm['$this->upload'] = $nameFile;
            //     }
            // }

            $data->update($dataForm);

            return response()->json($data, 201);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th], 404);
        }
    }


    public function destroy($id)
    {
        try {

            if (!$data = $this->model->find($id)) {
                return response()->json(["error" => "não existe esse registro "], 404);
            }
            if ($data->image) {
                Storage::disk('public')->delete('clientes/$data->image');
            }
            $data->delete();

            return response()->json(['success' => 'Deletado com sucesso ']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
