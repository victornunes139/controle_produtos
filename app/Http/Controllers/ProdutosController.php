<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoCreateRequest;
use App\Http\Requests\ProdutoUpdateRequest;
use App\Repositories\ProdutoRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Entities\Produto;

class ProdutosController extends Controller
{
    private $repository;

    public function __construct(ProdutoRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Listar produtos que o usuário logado criou.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtosCriados = Produto::where('user_id', '=', Auth::user()->id)->get();

        return response()->json($produtosCriados);
    }

    /**
     * Criar um novo produto
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdutoCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $informacoes = $request->all();
            $resultadoBusca =  $this->repository->storeValidation($request->all());
            if($resultadoBusca) {
                $produto = Produto::create([
                                        'nome' => $informacoes["nome"],
                                        'user_id' => Auth::user()->id,
                                        'categoria_id' => $informacoes["categoria_id"]
                                        ]);
                                        
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Produto criado.',
                ]);
            } else {
                throw new \Exception("O produto já existe no banco de dados");
            }
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        } catch (\Exception $ex) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $this->exceptionMessage($ex),
            ]);
        }
    }

    /**
     * Listar apenas o produto desejado pelo usuário
     *
     * @param  int  $id(Produto)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resultadoBusca =  $this->repository->checkExist($id);    
        if($resultadoBusca["success"]) {
            if($resultadoBusca["produto"]->user_id == Auth::user()->id) {

                return response()->json([$resultadoBusca]); 
            } else {

                return response()->json([
                    'message' => 'Este produto não pertence ao usuário logado',
                ]); 
            }
        } else {
            
            return response()->json([$resultadoBusca]);
        }
    }

    /**
     * Atualizar o produto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProdutoUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $resultadoBusca =  $this->repository->checkExist($id);  
            if($resultadoBusca["success"]) {
                $informacao = $request->all();
                if($resultadoBusca["produto"]->user_id == Auth::user()->id) {
                    Produto::where('id', '=', $id)->update($informacao);

                    DB::commit();

                    return response()->json([
                        'success' => true,
                        'message' => 'Produto atualizado.',
                    ]);
                } else {
                    throw new \Exception("Você só pode atualizar os produtos que o usuário logado criou");
                }
            } else {
                return response()->json([$resultadoBusca]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        } catch (\Exception $ex) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $this->exceptionMessage($ex),
            ]);
        }
    }

    /**
     * Deletar o produto.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $resultadoBusca =  $this->repository->checkExist($id);
            if($resultadoBusca["success"]) { 
                if($resultadoBusca["produto"]->user_id == Auth::user()->id) {
                    Produto::where('id', '=', $id)->delete($id);

                    DB::commit();

                    return response()->json([], 204);
                } else {
                    throw new \Exception("Você só pode deletar os produtos que o usuário logado criou");
                }
            } else {
                return response()->json([$resultadoBusca]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        } catch (\Exception $ex) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $this->exceptionMessage($ex),
            ]);
        }
    }
}
