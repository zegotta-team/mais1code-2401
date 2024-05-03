<?php

spl_autoload_register(function ($nomeClasse) {
    require_once "./classes/" . strtolower($nomeClasse) . ".php";
});

include './funcoes.php';

$opcao = null;

do {
//    system('clear');
    echo "*** MENU ***\n";
    echo "[1] Cadastrar empresa\n";
    echo "[2] Editar empresa\n";
    echo "[3] Remover empresa\n";
    echo "[4] Cadastrar vaga\n";
    echo "[5] Editar vaga\n";
    echo "[6] Remover vaga\n";
    echo "[0] Encerrar\n";
    echo "Olá, usuário. Escolha sua opção: ";
    $opcao = intval(trim(fgets(STDIN)));

    if ($opcao > 6) {
        echo "Opção inválida\n";
    }

//    $empresas = Empresa::listaEmpresas();
//
//    foreach ($empresas as $empresa) {
//        echo $empresa->getId(). " " . $empresa->getNome() . "\n";
//    }
//
//    die();

    match ($opcao) {
        1 => criarEmpresa(),
        4 => cadastraVaga(),
        6 => removerVaga(),
        default => null
    };

} while ($opcao > 0);
