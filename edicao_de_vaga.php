<?php

spl_autoload_register(function ($nomeClasse) {
    require_once "./classes/" . strtolower($nomeClasse) . ".php";
});

include './funcoes.php';

do{
    echo "Informe parte do nome da empresa ou cnpj da empresa ou parte do título da vaga: ";
    $filtro = trim(fgets(STDIN));

    $results = Vaga::selecionaDados($filtro);

    if (!empty($results)) {
        echo "Informação passada pela busca válida. \n";

        print_r($results);

        do{
            echo "Informe o id da vaga que deseja alterar: ";
            $id = intval(trim(fgets(STDIN)));
        } while($id <= 0);
        //var_dump($id);
    } else{
        echo "Informação passada na busca inválida. Tente novamente! \n";
    }

} while(empty($id));

do{

    do{
        echo "Deseja realmente fazer alguma alteração na vaga (sim/nao): ";
        $resposta = trim(fgets(STDIN));
    } while($resposta !== 'sim' && $resposta !== 'nao');
    
    //var_dump($resposta);

    if ($resposta == 'sim') {
        do{
            echo "Informe o número do campo que deseja alterar:
                1 - titulo; 
                2 - email;
                3 - salário;
                4 - benefícios;
                5 - descrição;
                6 - requisitos;
                7 - carga horária. \n";
            $campo = trim(fgets(STDIN));
        } while($campo !== '1' && $campo !== '2' && $campo!== '3' && $campo !== '4' && $campo !== '5' && $campo !== '6' && $campo !== '7');

        //var_dump($campo);

        if ($campo == 1) {
            $alteracao = 'titulo';

            $novoDado = captarTitulo();
        } elseif ($campo == 2) {
            $alteracao = 'email';

            $novoDado = captarEmail();
        } elseif ($campo == 3) {
            $alteracao = 'salario';

            $novoDado = captarSalario();
        } elseif ($campo == 4) {
            $alteracao = 'beneficios';

            $novoDado = captarBeneficios();
        } elseif ($campo == 5) {
            $alteracao = 'descricao';

            $novoDado = captarDescricao();
        } elseif ($campo == 6) {
            $alteracao = 'requisitos';

            $novoDado = captarRequisitos();
        } elseif ($campo == 7) {
            $alteracao = 'cargaHoraria';

            $novoDado = captarCargaHoraria();
        }

        //var_dump($novoDado);

        if (!empty($alteracao) && !empty($novoDado) && !empty($id)) {
            Vaga::alteraDados($alteracao, $novoDado, $id);
        }
    }
} while($resposta != 'nao');
