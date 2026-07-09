<?php 

//regras de negocio

require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/data.php';

function getAllUsers (string $dataFile): array
{
    $data = loadData($dataFile);
    return ['users' => $data['users']];
}

function createUser(string $dataFile, ?array $input) :array
{
    if (!is_array($input)){
        return ['error' => 'invalid JSON body', 'status' => 400];
    }

    $error = validadeRequiredFields($input, ['name', 'age', 'email']);
    if ($error) {
        return ['error' => $error , 'status' => 400];
    }
    $error = validadeUserFields($input);
    if ($error){
        return ['error' => $error , 'status' => 400];
    }
    
    $user = insertUser($dataFile, [
        'name' => trim($input['name']),
        'age' => (int) $input['age'],
        'email' => $input['email'],
    ]);

    return ['data' => $user, 'status' => 201];
}

function editUser(string $dataFile, ?int $id, ?array $input, bool $partial = false) :array
{
    if ($id === null){
        return ['error' => 'User id is required', 'status' => 400];
    }

    if(!is_array($input)){
        return ['error' => 'invalid json body', 'status' => 400];
    }

    if(!$partial) {
        $error = validateRequiredFields($input, ['name','age','email']);
        if($error) {
            return ['error' => $error , 'status' => 400];
        }
    }

    $error = validateUserFields($input);
    if($error) {
        return ['error' => $error , 'status' => 400];
    }

    $allowed = ['name', 'age', 'email'];
    //fala os campos maximos que podem colocar
    $fields = array_intersect_key($input, array_flip($allowed));
    //aqui ele verifica se tiver mais campos ele deleta, 
    //esse array_intersect_key ele compara as chaves 
    //as chaves viram 0,1,2 pois tem 3 campos no $allowed então ele faz 3 chaves
    //depois o key compara e deleta as que sobraram evitando do usuario colocar mais coisas que pode 

    if(isset($fields['name'])) {
        $fields ['name'] = trim($fields['name']);
    }

    if(isset($fields['age'])) {
    $fields ['age'] = (int) $fields['age'];
    }

    $user = updateUser($dataFile, $id, $fields);

    if ($user === null) {
        return ['error' => 'User Not found' , 'status' => 404];
    }

    return ['data' => $user, 'status' => 200]; 
}

function removeUser(string $dataFile, ?int $id): array
{
    if ($id === null ){
        return ['error' => 'User id is required' , 'status' => 404];
    }
    
    $user = deleteUser($dataFile, $id);

    if($user === null) {
        return ['error' => 'User Not found' , 'status' => 404];
    }

    return ['data' => ['deleted' => $user], 'status' => 200];
}