<?php

namespace App\Repositories;

/**
 * Interface ProdutoRepository.
 *
 */
interface ProdutoRepository
{
    public function storeValidation(array $informacoes): bool;

    public function checkExist(int $id): array;
}
