<?php
include_once './funcoes.php';
include_once  './classes/empresa.php';


function editaEmpresa()

{




    echo "Digite o cnpj da empresa em que voce deseja listar: \n";
    $cnpj =  intval(trim(fgets(STDIN)));
    echo "Digite o nome da empresa em que voce deseja listar: \n";
    $nome = trim(fgets(STDIN));
    echo "digite o usuario da empresa: \n";
    $user = trim(fgets(STDIN));
    $dados = Empresa::verificaDadosExistentes($nome, $cnpj, $user);
    print_r($dados);

    if(!empty($dados)){
        echo "Quais dados da empresa voce deseja alterar?
      1- nome:
      2- cnpj:
      3- usuario:
      4- senha:
      5- descricao:;
      6- logo:
      7- endereco:\n";


        $dadosAcesso = trim(fgets(STDIN));
        echo "Você digitou o numero: $dadosAcesso \n";

        if ($dadosAcesso == 1) {
            echo "Informe o nome atualizado da empresa \n";
            $dadoRecebido = trim(fgets(STDIN));

            $diretorio_raiz = dirname(__DIR__);
            $caminho_banco = realpath($diretorio_raiz . EMPRESA:: BANCO);

            $pdo = new PDO("sqlite:" . '/' );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            $sql = "UPDATE empresa SET nome= $dadoRecebido WHERE cnpj = $cnpj AND usuario = $user ";


            $stmt = $pdo->prepare($sql);
            var_dump($stmt);
            $stmt->execute();
        }
    }else {
        echo "Empresa nao localizada";

    }

    die();




    if ($dadosAcesso == 1) {
        echo "Informe o nome atualizado da empresa \n";
        $dadoRecebido = trim(fgets(STDIN));

        $sql = "UPDATE empresa SET nome = \"$dadoRecebido\" WHERE nome LIKE :curinga OR usuario LIKE :curinga";
    } else if ($dadosAcesso == 2) {
        echo "Informe o cnpj atualizado da empresa \n ";
        $dadoRecebido = trim(fgets(STDIN));
        $sql = "UPDATE empresa SET cnpj = $dadoRecebido  WHERE nome LIKE :curinga OR usuario LIKE :curinga";
    } else if ($dadosAcesso == 3) {
        $dadoRecebido = captarUsuario();
        $sql = "UPDATE empresa SET usuario = \"$dadoRecebido\"  WHERE nome LIKE :curinga OR usuario LIKE :curinga";
    } else if ($dadosAcesso == 4) {
        $dadoRecebido = captarSenha();
        $sql = "UPDATE empresa SET senha = $dadoRecebido WHERE nome LIKE :curinga OR usuario LIKE :curinga";
    } else if ($dadosAcesso == 5) {
        $dadoRecebido = captarDescricao();
        $sql = "UPDATE empresa SET descricao = \"$dadoRecebido\"  WHERE nome LIKE :curinga OR usuario LIKE :curinga";
    } else if ($dadosAcesso == 6) {
        $dadoRecebido = captarLogo();
        $sql = "UPDATE empresa SET logo = \"$dadoRecebido\"  WHERE nome LIKE :curinga OR usuario LIKE :curinga";
    } else if ($dadosAcesso == 7) {
        $dadoRecebido = captarEndereco();
        $sql = "UPDATE empresa SET endereco = \"$dadoRecebido\"  WHERE nome LIKE :curinga OR usuario LIKE :curinga";
    }












}
editaEmpresa();