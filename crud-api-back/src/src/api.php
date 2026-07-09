<?php

//dispatch por metodo ()

require_once __DIR__ . '/controllers.php';

$method = $_SERVER['REQUEST_METHOD'];
//aqui ele pega o request method da requisição

match ($method)
{
    'GET' => handleGet($dataFile),
    'POST' => handlePost($dataFile),
    'PUT' => handlePut($dataFile),
    'PATCH' => handlePatch($dataFile),
    'DELETE' => handleDelete($dataFile),
    default => handleMethodNotAllowed(),
};
//dpois ele compara e fala oq fazer caso seja o caso