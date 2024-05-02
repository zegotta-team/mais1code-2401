<?php
include_once './funcoes.php';

function cadastraVaga(){

    echo "Olá seja bem-vindo, aqui você pode cadastrar sua vaga: \n";

    echo 'Digite o numero identificador de sua vaga: ';
    $cadastroId = trim(fgets(STDIN));


    $cadastroEmail = captarEmail();

    $cadastroSalario = captarSalario();

    $cadastroBeneficios = captarBeneficios();

    $cadastroDescricao = captarDescricao();

    $cadastroRequisitos = captarRequisitos();

    $cadastroCargaHoraria = captarCargaHoraria();


    $pdo = new PDO("sqlite:db.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO vaga(empresa_id, email, salario, beneficios, descricao, requisitos, cargaHoraria)
            VALUES(\"$cadastroId\", \"$cadastroEmail\", \"$cadastroSalario\", \"$cadastroBeneficios\", \"$cadastroDescricao\", \"$cadastroRequisitos\",\"$cadastroCargaHoraria\")";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
cadastraVaga();

