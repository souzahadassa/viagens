<?php
// index.php

require __DIR__ . '/../vendor/autoload.php';   // ajuste para '/vendor/...' se estiver na raiz

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();



// ----- 5 missões iniciais -----
$missoes = [
    ['id' => 1, 'nome' => 'Apollo 11',         'ano' => 1969, 'agencia' => 'NASA',   'status' => 'Concluída'],
    ['id' => 2, 'nome' => 'Voyager 1',         'ano' => 1977, 'agencia' => 'NASA',   'status' => 'Em operação'],
    ['id' => 3, 'nome' => 'Artemis II',        'ano' => 2026, 'agencia' => 'NASA',   'status' => 'Planejada'],
    ['id' => 4, 'nome' => 'Sputnik 1',         'ano' => 1957, 'agencia' => 'URSS',   'status' => 'Concluída'],
    ['id' => 5, 'nome' => 'Falcon Heavy Demo', 'ano' => 2018, 'agencia' => 'SpaceX', 'status' => 'Concluída'],
];

// ----- Função auxiliar -----
function jsonResponse(Response $response, $data, int $status = 200): Response
{
    $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
}

// ----- GET /status -----
$app->get('/status', function (Request $request, Response $response) {
    return jsonResponse($response, ['status' => 'ok'], 200);
});

// ----- GET /missoes -----
$app->get('/missoes', function (Request $request, Response $response) use ($missoes) {
    return jsonResponse($response, array_values($missoes), 200);
});

// ----- GET /missoes/{id} -----
$app->get('/missoes/{id}', function (Request $request, Response $response, array $args) use ($missoes) {
    $id = (int) $args['id'];
    foreach ($missoes as $missao) {
        if ($missao['id'] === $id) {
            return jsonResponse($response, $missao, 200);
        }
    }
    return jsonResponse($response, ['erro' => 'Missão não encontrada'], 404);
});

// ----- POST /missoes -----
$app->post('/missoes', function (Request $request, Response $response) use (&$missoes) {
    $dados = $request->getParsedBody();

    if (empty($dados['nome']) || empty($dados['ano']) || empty($dados['agencia']) || empty($dados['status'])) {
        return jsonResponse($response, ['erro' => 'Campos obrigatórios: nome, ano, agencia, status'], 400);
    }

    $novoId = empty($missoes) ? 1 : max(array_column($missoes, 'id')) + 1;

    $novaMissao = [
        'id'      => $novoId,
        'nome'    => $dados['nome'],
        'ano'     => (int) $dados['ano'],
        'agencia' => $dados['agencia'],
        'status'  => $dados['status'],
    ];

    $missoes[] = $novaMissao;

    return jsonResponse($response, $novaMissao, 201);
});

// ----- PUT /missoes/{id} -----
$app->put('/missoes/{id}', function (Request $request, Response $response, array $args) use (&$missoes) {
    $id = (int) $args['id'];
    $dados = $request->getParsedBody();

    foreach ($missoes as $i => $missao) {
        if ($missao['id'] === $id) {
            if (isset($dados['nome']))    $missoes[$i]['nome']    = $dados['nome'];
            if (isset($dados['ano']))     $missoes[$i]['ano']     = (int) $dados['ano'];
            if (isset($dados['agencia'])) $missoes[$i]['agencia'] = $dados['agencia'];
            if (isset($dados['status']))  $missoes[$i]['status']  = $dados['status'];
            return jsonResponse($response, $missoes[$i], 200);
        }
    }
    return jsonResponse($response, ['erro' => 'Missão não encontrada'], 404);
});

// ----- DELETE /missoes/{id} -----
$app->delete('/missoes/{id}', function (Request $request, Response $response, array $args) use (&$missoes) {
    $id = (int) $args['id'];
    foreach ($missoes as $i => $missao) {
        if ($missao['id'] === $id) {
            array_splice($missoes, $i, 1);
            return $response->withStatus(204);
        }
    }
    return jsonResponse($response, ['erro' => 'Missão não encontrada'], 404);
});

$app->run();