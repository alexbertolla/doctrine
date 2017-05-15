<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace code\service;

use code\entity\Produto;
use Doctrine\ORM\EntityManager;

/**
 * Description of ProdutoService
 *
 * @author alex
 */
class ProdutoService {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function inserirProduto(Produto $produto) {
        $result = $this->em->persist($produto);
        $retorno['mensagem'] = ($result) ? 'Dados inseridos com sucesso' : 'Erro ao inserir dados';
        return $retorno;
    }

    public function alterarProduto(Produto $produto) {
        $produtoReference = $this->em->getReference(Produto::class, $produto->getId());
        $result = $this->em->merge($produtoReference);
        $this->em->flush();
        $retorno['mensagem'] = ($result) ? 'Dados alterados com sucesso' : 'Erro ao alterar dados';
        return $retorno;
    }

    public function excluirProduto(Produto $produto) {
        $produtoReference = $this->em->getReference(Produto::class, $produto->getId());
        $result = $this->em->detach($produtoReference);
        $retorno['mensagem'] = ($result) ? 'Dados excluídos com sucesso' : 'Erro ao excluir dados';
        return $retorno;
    }

    public function buscarPorId($id) {
        return $this->em->getRepository(Produto::class)->find($id);
    }

    public function listarProdutos() {
        return $this->em->getRepository(Produto::class)->findAll();
    }

    public function listaPaginada($inicio, $maximo) {
        return $this->em->getRepository(Produto::class)->getListaPaginada($inicio, $maximo);
    }

    public function procurarPorNome($nome) {
        return $this->em->getRepository(Produto::class)->procurarPorNome($nome);
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
