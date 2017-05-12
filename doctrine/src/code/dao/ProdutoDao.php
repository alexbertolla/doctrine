<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace code\dao;

use code\entity\Produto;
use PDO;

/**
 * Description of ProdutoDao
 *
 * @author alex
 */
class ProdutoDao {

    private static $conn;

    public static function setConn() {
        try {
            $conn = new PDO('mysql:host=localhost;dbname=silex_api', 'root', 'root');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    function criarTabela($conn) {
        self::$conn = $conn;
        $createTable = "DROP TABLE IF EXISTS produtos;
            CREATE TABLE produtos ( 
            id INT NOT NULL AUTO_INCREMENT, 
            nome VARCHAR(45) NULL, 
            descricao VARCHAR(255) NULL, 
            valor DECIMAL(10,2) NULL, 
            PRIMARY KEY (`id`));";
        $insert = self::$conn->query($createTable);
        return ($insert) ? TRUE : FALSE;
    }

    public function inserirProduto(Produto $produto, $conn) {
        self::$conn = $conn;
        $sqlInsert = "INSERT INTO produtos (nome, descricao, valor) "
        . " VALUES('{$produto->getNome()}', '{$produto->getDescricao()}', {$produto->getValor()})";
        $smt = self::$conn->prepare($sqlInsert);
//        $smt->bindParam('nome', $produto->getNome());
//        $smt->bindParam('descricao', $produto->getDescricao());
//        $smt->bindParam('valor', $produto->getValor());
        return $smt->execute();
    }

    public function excluirProduto($id, $conn) {
        self::$conn = $conn;
        $sql = "DELETE FROM produtos WHERE id = {$id};";
        $smt = self::$conn->prepare($sql);
        return $smt->execute();
    }

    public function listarProdutos($conn) {
        self::$conn = $conn;
        $sql = "SELECT * FROM produtos ORDER BY nome";
        $stm = self::$conn->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function buscarPorId($id, $conn) {
        self::$conn = $conn;
        $sql = "SELECT * FROM produtos WHERE id = {$id}";
        $stm = self::$conn->prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    public function alterarProduto(Produto $produto, $conn) {
        self::$conn = $conn;
        $sql = "UPDATE produtos"
                . " SET nome = '{$produto->getNome()}',"
                . " descricao = '{$produto->getDescricao()}',"
                . " valor = '{$produto->getValor()}'"
                . " WHERE id = {$produto->getId()};";
        $stm = self::$conn->prepare($sql);
        return $stm->execute();
    }

}
