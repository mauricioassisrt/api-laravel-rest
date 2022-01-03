<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as Image;

class ClienteController extends Controller
{

    public function __construct(Cliente $cliente, Request $request)
    {
        $this->cliente = $cliente;
        $this->request = $request;
    }

    public function index()
    {
        $data = $this->cliente->all();

        $clientes = Cliente::all();
        return response()->json($data);
    }


    public function store(Request $request)
    {
        try {
            $this->validate($request, $this->cliente->rules());
            $dataForm = $request->all();

            // if ($request->hasFile('image') && $request->file('image')->isValid()) {
            //     $extension = $request->image->extension();
            //     $nome = uniqid(date('His'));
            //     $nameFile = "{$nome}.{$extension}";
            //     $upload = Image::make($dataForm['image'])->resize(177, 236)->
            //     save(storage_path("app/public/clientes/$nameFile", 70));
            //     if (!$upload) {
            //         return response()->json(['error' => 'Falha ao fazer upload', 500]);
            //     } else {
            //         $dataForm['image'] = $nameFile;
            //     }
            // }

            $data = $this->cliente->create($dataForm);
            return response()->json($data, 201);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }



    public function show($id)
    {
        try {


            if (!$data = $this->cliente->find($id)) {
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

            if (!$data = $this->cliente->find($id)) {
                return response()->json(["error" => "não existe esse registro para exibir "], 404);
            }

            $this->validate($request, $this->cliente->rules());
            $dataForm = $request->all();

            // if ($request->hasFile('image') && $request->file('image')->isValid()) {
            //   if ($data->image) {
            //     Storage::disk('public')->delete('clientes/$data->image');
            //  }
            //     $extension = $request->image->extension();
            //     $nome = uniqid(date('His'));
            //     $nameFile = "{$nome}.{$extension}";
            //     $upload = Image::make($dataForm['image'])->resize(177, 236)->
            //     save(storage_path("app/public/clientes/$nameFile", 70));
            //     if (!$upload) {
            //         return response()->json(['error' => 'Falha ao fazer upload', 500]);
            //     } else {
            //         $dataForm['image'] = $nameFile;
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

            if (!$data = $this->cliente->find($id)) {
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
