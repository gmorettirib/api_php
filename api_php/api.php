<?php

    header("Content-Type: application/json");

    $metodo = $_SERVER['REQUEST_METHOD'];

    
    
    // $usuarios = [
    //     ["id" => 1, "nome" => "Maria Souza", "email" => "maria@email.com"],
    //     ["id" => 2, "nome" => "Joao Silva", "email" => "joao@email.com"]
    // ];
    // recupera o arquivo json
    $arquivo = 'usuarios.json';

    //verifica se o arquivo, se nao criar um array vazio
    if (!file_exists($arquivo)) {
        file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    $usuarios = json_decode(file_get_contents($arquivo), true);
    
    switch ($metodo) {
        case 'GET':
            // echo "ações do get";
            echo json_encode($usuarios);
            break;

        case 'POST':
            // echo "ações do post";
            $dados = json_decode(file_get_contents('php://input'), true);
            // print_r($dados);
            $novoUsuario = [
                "id" => $dados["id"],
                "nome" => $dados["nome"],
                "email" => $dados["email"]
            ];
            // Adiciona o novo usuario na array existente
            array_push($usuarios, $novoUsuario);
            echo json_encode('Usuario inserido com sucesso!');
            print_r($usuarios);
            break;
        
        default:
            echo "método não encontrado";
            break;
    }


?>