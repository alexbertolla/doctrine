<?php

/**
 * Uma vez que você já possui uma API pública em funcionamento de seu produto, 
 * agora, você poderá categorizar todos os produtos da seguinte forma:

  1) Um produto pode estar apenas em uma categoria
  2) Um produto pode ter diversas tags para facilitar o processo de busca
  3) As tags precisam constar em uma tabela de banco de dados

  Também:

  Crie as APIs REST para: Categorias e Tags (CRUD Completo).
  No momento da inserção de um novo produto, a categoria do mesmo deverá ser
 * informada, bem como suas tags.
 */
use code\service\ProdutoService;
use code\service\TagService;
use code\service\CategoriaService;
use Symfony\Component\HttpFoundation\Request;
use code\entity\Produto;
use code\entity\Categoria;
use code\entity\Tag;

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

$app['categoriaService'] = function () use($em) {
    $service = new CategoriaService($em);
    return $service;
};

$app['tagService'] = function () use($em) {
    $service = new TagService($em);
    return $service;
};


$app->post('/api/categorias', function (Request $request) use($app) {

    $dados = $request->request->all();
    $categoria = new Categoria();
    $categoria->setNome($dados['nome']);
    $resultado = $app['categoriaService']->inserirCategoria($categoria);

    return $app->json($resultado);
});


$app->put('/api/categorias', function (Request $request) use($app) {

    $dados = $request->request->all();
    $categoria = new Categoria();
    $categoria->setId($dados['id']);
    $categoria->setNome($dados['nome']);
    $resultado = $app['categoriaService']->alterarCategoria($categoria);

    return $app->json($resultado);
});

$app->delete('/api/categorias', function (Request $request) use($app) {

    $dados = $request->request->all();
    $categoria = new Categoria();
    $categoria->setId($dados['id']);
    $resultado = $app['categoriaService']->excluirCategoria($categoria);

    return $app->json($resultado);
});

$app->get('/api/categorias/listar', function () use($app) {
    $resultado = $app['categoriaService']->listarCategorias();
    return $app->json($resultado);
});

$app->get('/api/categorias/{id}', function ($id) use($app) {
    $categoria = new Categoria();
    $categoria->setId($id);
    $resultado = $app['categoriaService']->buscarPorId($id);
    return $app->json($resultado);
});


$app->post('/api/tags', function (Request $request) use($app) {

    $dados = $request->request->all();
    $tag = new Tag();
    $tag->setNome($dados['nome']);
    $resultado = $app['tagService']->inserirTag($tag);

    return $app->json($resultado);
});


$app->put('/api/tags', function (Request $request) use($app) {

    $dados = $request->request->all();
    $tag = new Tag();
    $tag->setId($dados['id']);
    $tag->setNome($dados['nome']);
    $resultado = $app['tagService']->alterarTag($tag);

    return $app->json($resultado);
});

$app->delete('/api/tags', function (Request $request) use($app) {

    $dados = $request->request->all();
    $tag = new Taga();
    $tag->setId($dados['id']);
    $resultado = $app['tagService']->excluirTag($tag);

    return $app->json($resultado);
});

$app->get('/api/tags/listar', function () use($app) {
    $resultado = $app['tagService']->listarTags();
    return $app->json($resultado);
});

$app->get('/api/tags/{id}', function ($id) use($app) {
    $tag = new Tag();
    $tag->setId($id);
    $resultado = $app['tagService']->buscarPorId($id);
    return $app->json($resultado);
});


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



    $categoria = $app['categoriaService']->buscarPorId($dados['categoriaId']);
    $produto->setCategoria($categoria);

    $listaTag = explode(',', $dados['tagId']);
    foreach ($listaTag as $tag) {
        $produto->addTag($app['tagService']->buscarPorId($tag));
    }

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

    $categoria = $app['categoriaService']->buscarPorId($dados['categoriaId']);
    $produto->setCategoria($categoria);

    $listaTag = explode(',', $dados['tagId']);
    foreach ($listaTag as $tag) {
        $produto->addTag($app['tagService']->buscarPorId($tag));
    }

    $produto->setTag($tag);

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
