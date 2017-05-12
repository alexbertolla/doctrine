<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace code\mapper;

use code\entity\Produto;
use code\dao\ProdutoDao;
use Doctrine\ORM\EntityManager;

/**
 * Description of ProdutoMapper
 *
 * @author alex
 */
class ProdutoMapper {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function inserirProduto(Produto $produto) {
        $this->em->persist($produto);
        $this->em->flush();
        return TRUE;
    }

    public function alterarProduto(Produto $produto) {
        $this->em->merge($produto);
        $this->em->flush();
        return TRUE;
    }

    public function excluirProduto(Produto $produto) {
        $this->em->remove($produto);
        $this->em->flush();
        return TRUE;
    }

    public function listarProdutos() {
        $conn = ProdutoDao::setConn();
        $produtoDao = new ProdutoDao();
        $resultado = $produtoDao->listarProdutos($conn);
        return $resultado;
    }

    public function cirarTabela() {
        $conn = ProdutoDao::setConn();
        $produtoDao = new ProdutoDao();
        $resultado = $produtoDao->criarTabela($conn);
        return $resultado;
    }

    public function buscarPorId($id) {
        return $this->em->find(Produto::class, $id);
    }

}
