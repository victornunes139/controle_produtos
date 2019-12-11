<?php

namespace App\Repositories;

use App\Repositories\ProdutoRepository;
use App\Entities\Produto;

/**
 * Class ProdutoRepositoryEloquent.
 *
 */
class ProdutoRepositoryEloquent implements ProdutoRepository
{
    /**
     * Verifica se o produto ja foi criado
     *
     * @param  array  $informacoes
     * @return bool
     */
    public function storeValidation(array $informacoes): bool
    {
        $resultadoBusca = Produto::where('nome', '=', $informacoes["nome"])->where('categoria_id', '=', $informacoes["categoria_id"])->get();

        if(count($resultadoBusca) == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verifica se o produto existe no banco
     *
     * @param  int  $id
     * @return array
    */
    public function checkExist(int $id): array
    {
        $produto = Produto::find($id);

        if(!$produto)
        {
            return [
                'success' => false,
                'message' => 'Produto não encontrado'
            ];
        } else {
            return [
                'success' => true,
                'produto' => $produto
            ];
        }
    }
}
