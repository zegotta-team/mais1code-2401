<?php

spl_autoload_register(function ($nomeClasse) {
    require_once "web/classes/$nomeClasse.php";
});

include './funcoes.php';

$opcao = null;

do {
    echo "Olá, usuário. Escolha sua opção:\n";
    echo "[1] Login\n";
    echo "[2] Cadastrar empresa\n";
    $opcao = intval(trim(fgets(STDIN)));

    if ($opcao > 2) {
        echo "Opção inválida\n";
    }

    if ($opcao === 2) {
        criarEmpresa();
    }
} while ($opcao !== 1 && $opcao !== 2);

do {
    $empresaLogada = login();
} while (empty($empresaLogada));

system('clear');
do {
    echo "*** MENU ***\n";
    echo "[1] Editar empresa\n";
    echo "[2] Remover empresa\n";
    echo "[3] Cadastrar vaga\n";
    echo "[4] Editar vaga\n";
    echo "[5] Remover vaga\n";
    echo "[0] Encerrar\n";
    echo "Opção: ";
    $opcao = intval(trim(fgets(STDIN)));

    if ($opcao > 5) {
        echo "Opção inválida\n";
    }

    match ($opcao) {
        1 => editarEmpresa($empresaLogada),
        2 => removerEmpresa($empresaLogada),
        3 => cadastrarVaga($empresaLogada),
        4 => editarVaga($empresaLogada),
        5 => removerVaga($empresaLogada),
        default => null
    };

    if ($opcao === 2) {
        $opcao = -1;
    }
} while ($opcao > 0);
