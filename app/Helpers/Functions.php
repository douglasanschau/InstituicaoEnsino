<?php

function mensagensSucesso($tipo, $atributo){

    $titulo   = "";
    $mensagem = "";
    $atributo = ucfirst($atributo);

    switch($tipo){
        case 'cadastrar':
            $titulo   = "{$atributo} Cadastrado!"; 
            $mensagem = "O {$atributo} foi cadastrado com sucesso.";
        break;
        case 'editar':
            $titulo   = "{$atributo} Editado!"; 
            $mensagem = "O {$atributo} foi editado com sucesso.";
        break;
        default: 
            $titulo   = "{$atributo} Desativado!"; 
            $mensagem = "O {$atributo} foi desativado com sucesso.";
        break;
    }

    return array('titulo' => $titulo, 'mensagem' => $mensagem);
}


?>