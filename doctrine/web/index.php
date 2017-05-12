<?php

/**
 * Agora que você já possui uma API pública de seu projeto com Silex, 
 * faça uma mudança em seu projeto (da forma mais sutil possível),
 *  para alterar o formato atual para persistir os dados no banco de dados 
 * com o Doctrine nas condições de Adicionar, Alterar e Remover um registro.
 */
use code\service\ProdutoService;
use Symfony\Component\HttpFoundation\Request;
use code\entity\Produto;

require_once '../vendor/autoload.php';
require_once '../bootstrap.php';


$app = new \Silex\Application();
$app['debug'] = TRUE;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => '../views',
));

$app->register(new \Silex\Provider\RoutingServiceProvider());



$app['produtoService'] = function () use($em) {
    $produto = new \code\entity\Produto();
    $mapper = new \code\mapper\ProdutoMapper($em);
    $service = new ProdutoService($produto, $mapper);
    return $service;
};



$app->post('/api/produtos', function (Request $request) use($app) {

    $dados = $request->request->all();
    $produto = new Produto();
    $produto->setNome($dados['nome']);
    $produto->setDescricao($dados['descricao']);
    $produto->setValor($dados['valor']);
    $resultado = $app['produtoService']->inserirProduto($produto);

    return $app->json($resultado);
});

$app->put('/api/produtos', function (Request $request) use($app) {

    $dados = $request->request->all();

    $produto = new Produto();
    $produto->setId($dados['id']);
    $produto->setNome($dados['nome']);
    $produto->setDescricao($dados['descricao']);
    $produto->setValor($dados['valor']);

    $resultado = $app['produtoService']->alterarProduto($produto);

    return $app->json($resultado);
});

$app->delete('/api/produtos', function (Request $request) use($app) {

    $id = $request->request->get('id');
    $produto = $app['produtoService']->buscarPorId($id);
    $resultado = $app['produtoService']->excluirProduto($produto);


    return $app->json($resultado);
});

$app->run();
