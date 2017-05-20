<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace code\service;

use code\entity\Categoria;
use Doctrine\ORM\EntityManager;

class CategoriaService {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function inserirCategoria(Categoria $categoria) {
        $result = $this->em->persist($categoria);
        $this->em->flush();
        $retorno['mensagem'] = ($result) ? 'Dados inseridos com sucesso' : 'Erro ao inserir dados';
        return $retorno;
    }

    public function alterarCategoria(Categoria $categoria) {
        $categoriaReference = $this->em->getReference(Categoria::class, $categoria->getId());
        $categoriaReference->setNome($categoria->getNome());
        $result = $this->em->merge($categoriaReference);
        $this->em->flush();
        $retorno['mensagem'] = ($result) ? 'Dados alterados com sucesso' : 'Erro ao alterar dados';
        return $retorno;
    }

    public function excluirCategoria(Categoria $categoria) {
        $categoriaReference = $this->em->getReference(Categoria::class, $categoria->getId());
        $result = $this->em->remove($categoriaReference);
        $this->em->flush();
        $retorno['mensagem'] = ($result) ? 'Dados excluídos com sucesso' : 'Erro ao excluir dados';
        return $retorno;
    }

    public function buscarPorId($id) {
        return $this->em->getRepository(Categoria::class)->find($id);
    }

    public function listarCategorias() {
        return $this->em->getRepository(Categoria::class)->findAll();
    }

}
