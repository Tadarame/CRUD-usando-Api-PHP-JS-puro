<?php

//validação

function validadeRequiredFields(array $input, array $fields) : ?string
{
    $missing = [];

    foreach ($fields as $field){
        if (!isset($input[$field])){
            $missing[] = $field;
            //preenche os campos ausentes
        }
    }

    if (!empty($missing)) {
        return implode (',' , $missing) . 'are required';
    }

    return null;
}

function validadeUserFields(array $input) : ?string 
{
    if (isset($input['name'])) {
        $name = trim($input['name']);
        //isset verifica se existe 'name' caso sim ele 
        //faz o $name virar o 'name' sem espaços
        if($name === ''){
            return 'name cannot be empty';
        }
        
        if(strlen($name) > 100 ){
            return 'name must be at most 100 character';
            //ve se o $name tem mais de 100 caracteres
        }
    }

    if(isset($input['age'])) {
        //verifica se existe a age
        if (!is_numeric($input['age'])) {
            //verifica se o $input é um numero diferente
            //do inteiro 
            return 'Age must be a number';
        }

        $age = (int) $input['age'];

        if ($age <1 || $age > 150) {
            return 'Age must be between 1 and 150';
        }
    }

    if (isset($input['email'])){
        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Invalid email format';
            //aqui ele filtra se o email é invalido usando o 
            //FILTER_VALIDATE_EMAIL
        }
    }

    return null;
}