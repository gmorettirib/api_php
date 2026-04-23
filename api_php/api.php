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
            echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            break;

        case 'POST':
            // echo "ações do post";
            $dados = json_decode(file_get_contents('php://input'), true);
            // print_r($dados);

            if (!isset($dados["id"]) || !isset($dados["nome"]) || !isset($dados["email"])){
                http_response_code(400);             
                echo json_encode(["erro" => "Dados incompletos. "], JSON_UNESCAPED_UNICODE);
                exit;
            }
            $novo_usuario = [
                "id" => $dados["id"],
                "nome" => $dados["nome"],
                "email" => $dados["email"]
            ];

            $usuarios[] = $novo_usuario;
            file_put_contents($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            echo json_encode(["mensagem" => "Usuário inserido com sucesso!", "usuarios" => $usuarios], JSON_UNESCAPED_UNICODE);
            // // Adiciona o novo usuario na array existente
            // array_push($usuarios, $novoUsuario);
            // echo json_encode('Usuario inserido com sucesso!');
            // print_r($usuarios);
            break;
        
        default:
            // echo "método não encontrado";
            http_response_code(405);
            echo json_encode(["erro" => "Metodo não permitido!"], JSON_UNESCAPED_UNICODE);
            break;
    }


?>