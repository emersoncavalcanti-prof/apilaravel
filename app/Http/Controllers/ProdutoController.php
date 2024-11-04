<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Produto::all();
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request)
    {
        $validatedData = $request->validated();
        $produto = Produto::create($validatedData);

        return response()->json([
            'message' => 'Produto criado com sucesso',
            'data' => $produto
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        try {
            $produto = Produto::findOrFail($produto->id);
            return response()->json([
                'message' => 'Produto encontrado com sucesso',
                'data' => $produto
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Produto não encontrado',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request,$id)
    {
        $data = $request->all();

        $produto = Produto::find($id);

        if(!$produto){
            return response()->json([
                'message' => 'Produto não encontrado',
            ], Response::HTTP_NOT_FOUND);
        }

        $response = $produto->update($data);

        if(!$response){
            return response()->json([
                'message' => 'Erro ao atualizar o produto',
            ], Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json([
                'message' => 'Produto atualizado com sucesso',
                'data' => $produto
            ], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $produto = Produto::findOrFail($id);
            $produto->delete();

            return response()->json([
                'message' => 'Produto deletado com sucesso',
            ], Response::HTTP_OK);

        }catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Produto não encontrado',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => 'Produto não encontrado',
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}
