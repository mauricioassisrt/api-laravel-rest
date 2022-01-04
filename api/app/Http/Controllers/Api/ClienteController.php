<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\MasterApiContoller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as Image;

class ClienteController extends MasterApiContoller
{
    protected $models;
    protected $path = 'clientes';
    protected $upload='image';
    public function __construct(Cliente $clientes, Request $request)
    {
        $this->model = $clientes;
        $this->request = $request;
    }

}
