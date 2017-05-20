<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace code\entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="code\entity\ProdutoRepository")
 * @ORM\Table(name="produtos")
 */
class Produto {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $nome;

    /**
     * @ORM\Column(type="text")
     */
    public $descricao;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2))
     */
    public $valor;

    /**
     * @ORM\ManyToOne(targetEntity="code\entity\Categoria")
     * @ORM\JoinColumn(name="categoriaId", referencedColumnName="id")
     */
    public $categoria;

    /**
     * @ORM\ManyToMany(targetEntity="code\entity\Tag")
     * @ORM\JoinTable(name="tagProdutos", 
     *              joinColumns={@ORM\JoinColumn(name="produtoId", referencedColumnName="id")},
     *              inverseJoinColumns={@ORM\JoinColumn(name="tagId", referencedColumnName="id")}
     * )
     */
    public $tag;

    public function __construct() {
        $this->tag = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getValor() {
        return $this->valor;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getTag() {
        return $this->tag;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function addTag($tag) {
        $this->tag->add($tag);
    }

}
