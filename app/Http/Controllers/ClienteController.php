<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    protected $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        // if ($request->has('atributos_modelo')) {
        //     $atributos_modelo = 'modelos:id,'.$request->atributos_modelo;

        //     $clienteRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        // }else {
        //     $clienteRepository->selectAtributosRegistrosRelacionados('modelo');
        // }

        if ($request->has('filtro')) {
            $clienteRepository->filtro($request->filtro);
        }

        if($request->has('atributos')){
            $clienteRepository->selectAtributos($request->atributos);
        }

        return response()->json($clienteRepository->getResultado(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate($this->cliente->rules());

        $cliente = $this->cliente->create([
            'nome' => $request->nome,
        ]);

        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = $this->cliente->find($id);
        if($cliente === null)
        {
            return response()->json(['erro' => 'Recurso Pesquisado não existe'], 404);
        }

        return response()->json($cliente, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $cliente = $this->cliente->find($id);

        if ($cliente === null) {
            return response()->json(['erro' => 'impossivel atualizar, recurso inexistente'], 404);
        }

        if ($request->method() === 'PATCH') {
            $regras = array();

            foreach($cliente->rules() as $input => $regra){

                if(array_key_exists($input, $request->all())){
                    $regras[$input] = $regra;
                }
            }
            $request->validate($regras);


        } else {
            $request->validate($cliente->rules());
        }

        $cliente->fill($request->all());
        $cliente->save();

        return response()->json($cliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $cliente = $this->cliente->find($id);
        if ($cliente === null) {
            return response()->json(['erro' => 'impossivel deletar, recurso inexistente'], 404);
        }

        $cliente->delete();

        return response()->json(['msg' => 'O cliente foi removida com sucesso'], 200);
    }
}
