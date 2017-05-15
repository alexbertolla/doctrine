<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace code\entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ProdutoRepository
 *
 * @author alex
 */
class ProdutoRepository extends EntityRepository {

    public function getListaPaginada($offSet, $limit) {
        return $this->createQueryBuilder("p")
                        ->orderBy('p.nome', 'ASC')
                        ->setFirstResult($offSet)
                        ->setMaxResults($limit)
                        ->getQuery()
                        ->getResult();
    }

    public function procurarPorNome($nome) {
        return $this->findByNome($nome);
    }

}
