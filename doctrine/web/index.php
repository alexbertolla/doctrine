<?php

/**
 * - Faça uma refatoração completa no sistema para utilizar adequadamente a 
 * persistência de dados (incluindo a utilização do getReference).

  - Crie um sistema de busca utilizando repositories sendo que os métodos podem
 *  utilizar queryBuilder ou DQL.

  - Faça a listagem de dados utilizando paginação (os parâmetros podem ser
 * passados via queryString
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
    $service = new ProdutoService($em);
    return $service;
};

$app->get('/procurarPorNome/{nome}', function ($nome) use($app) {
    $resultado = $app['produtoService']->procurarPorNome($nome);
    return $app->json($resultado);
});

$app->get('/listaPaginada/{inicio}&{maximo}', function ($inicio, $maximo) use($app) {
    $resultado = $app['produtoService']->listaPaginada($inicio, $maximo);
    return $app->json($resultado);
});

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
