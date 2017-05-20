<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace code\service;

use code\entity\Tag;
use Doctrine\ORM\EntityManager;

class TagService {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function inserirTag(Tag $tag) {
        $result = $this->em->persist($tag);
        $this->em->flush();
        $retorno['mensagem'] = ($result) ? 'Dados inseridos com sucesso' : 'Erro ao inserir dados';
        return $retorno;
    }

    public function alterarTag(Tag $tag) {
        $tagReference = $this->em->getReference(Tag::class, $tag->getId());
        $tagReference->setNome($tag->getNome());
        $result = $this->em->merge($tagReference);
        $this->em->flush();
        $retorno['mensagem'] = ($result) ? 'Dados alterados com sucesso' : 'Erro ao alterar dados';
        return $retorno;
    }

    public function excluirTag(Tag $tag) {
        $tagReference = $this->em->getReference(Tag::class, $tag->getId());
        $result = $this->em->remove($tagReference);
        $this->em->flush();
        $retorno['mensagem'] = ($result) ? 'Dados excluídos com sucesso' : 'Erro ao excluir dados';
        return $retorno;
    }

    public function buscarPorId($id) {
        return $this->em->getRepository(Tag::class)->find($id);
    }

    public function listarTags() {
        return $this->em->getRepository(Tag::class)->findAll();
    }

}
