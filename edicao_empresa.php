<?php
include_once './funcoes.php';
function editar()

{

    echo "Digite a empresa que deseja listar: \n";
    $buscar = '%' . trim(fgets(STDIN)) . '%';

    $pdo = new PDO("sqlite:" . 'db.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlListName = "SELECT * FROM empresa WHERE nome LIKE :curinga OR usuario LIKE :curinga";
    var_dump($sqlListName);

    $stmt = $pdo->prepare($sqlListName);


    $stmt->execute();




    echo "Quais dados da empresa voce deseja alterar?
  1- nome:
  2- cnpj:
  3- usuario:
  4- senha:
  5- descricao:
  6- logo:
  7- endereco:\n";

    $dadosAcesso = trim(fgets(STDIN));

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





    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':curinga', $buscar);
    $stmt->execute();
}
editar();