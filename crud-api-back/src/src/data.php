<?php 
//lê/grava dados no json

function loadData(string $dataFile): array
{
    return json_decode(file_get_contents($dataFile), true);
    //pega o $dataFile e transforma em array php
}

function saveData(string $dataFile, array $data): void
{
    file_put_contents($dataFile, json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    //salva as atualizações e mantes o json bonito e com acentuação
}

function insertUser(string $dataFile, array $user) :array
{
    $data = loadData($dataFile);

    $id = $data['nextId'] ?? 1;
    //o id recebe o nexid da data e caso nao tenha fica com o id 1

    $data['nextId'] = $id + 1;
    //faz o o id nunca se repetir pois o nextId seria igual ao ultimo mais 1

    $user['id'] = $id;
    //o $user array ganha a coluna id que recebe o id
    $data['users'][] = $user;

    saveData($dataFile, $data);
    //salva tudo legal bonito

    return $user;
}

function updateUser(string $dataFile, int $id, array $fields): ?array 
{
    $data = localData($dataFile);

    foreach ($data['users'] as $index => $user) {
        if ($user['id'] === $id ){
            $data['users'][$index] = array_merge($user,$fields);
            saveData($dataFile, $data);
            return $data['users'][$index];
        }
    }
    return null;
}

function deleteUser(string $dataFile, int $id) : ?array
{
    $data = loadData($dataFile);

    foreach($data['users'] as $index => $user) {
        if ($user['id'] === $id){
            array_splice($data['users'], $index, 1);
            //terira uma parte do array, levando o $indice e a quantidade
            saveData($dataFile, $data);
            return $user;
        }
    }
    return null;
}