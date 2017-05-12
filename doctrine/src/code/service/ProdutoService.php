<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace code\service;

use code\entity\Produto;
use code\mapper\ProdutoMapper;

/**
 * Description of ProdutoService
 *
 * @author alex
 */
class ProdutoService {

    private $produto;
    private $mapper;

    public function __construct(Produto $produto, ProdutoMapper $mapper) {
        $this->produto = $produto;
        $this->mapper = $mapper;
    }

    public function inserirProduto(Produto $produto) {
        $result = $this->mapper->inserirProduto($produto);
        $retorno['mensagem'] = ($result) ? 'Dados inseridos com sucesso' : 'Erro ao inserir dados';
        return $retorno;
    }

    public function alterarProduto(Produto $produto) {
        $result = $this->mapper->alterarProduto($produto);
        $retorno['mensagem'] = ($result) ? 'Dados alterados com sucesso' : 'Erro ao alterar dados';
        return $retorno;
    }

    public function excluirProduto(Produto $produto) {
        $result = $this->mapper->excluirProduto($produto);
        $retorno['mensagem'] = ($result) ? 'Dados excluídos com sucesso' : 'Erro ao excluir dados';
        return $retorno;
    }

    public function buscarPorId($id) {
        return $this->mapper->buscarPorId($id);
    }

    public function listarProdutos() {
        $produtoMapper = new ProdutoMapper();
        return $produtoMapper->listarProdutos();
    }

    public function criarTabela($arrayProdutos) {
        $produtoMapper = new ProdutoMapper();
        $result = FALSE;

        if ($produtoMapper->cirarTabela()) {
            $result = $this->inserirProdutos($arrayProdutos);
        }

        $retorno['mensagem'] = ($result) ? 'Tabela criada com sucesso' : 'Erro ao criar tabela';
        return $retorno;
    }

    public function inserirProdutos($produtos) {
        $retorno = FALSE;
        foreach ($produtos as $produto) {
            $retorno = $this->inserirProduto($produto['nome'], $produto['descricao'], $produto['valor']);
        }
        return $retorno;
    }

}
