<?php

abstract class FilialDTO implements DTOInterface
{
    use DbTrait;

    public static function verificar($cep, $estado)
    {
        $min = 8;
        $maxUf = 2;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            FlashMessage::addMessage('Usuário inválido (usuário precisa ser um email)', FlashMessage::FLASH_ERROR);
            header('Location: /candidato/cadastrar');
            die();
        } elseif (strlen($cpf) != $maxcpf || strlen($email) < $min) {
            FlashMessage::addMessage('CPF com quantidade de caracteres não permitida', FlashMessage::FLASH_ERROR);
            header('Location: /candidato/cadastrar');
            die();
        } elseif (strlen($senha) < 8) {
            FlashMessage::addMessage('Senha não atende ao padrão, deve ter no mínimo 8 caracteres', FlashMessage::FLASH_ERROR);
            header('Location: /candidato/cadastrar');
            die();
        } else {
            $pdo = static::conectarDB();

            $sql = "SELECT COUNT(1) AS Total FROM candidato WHERE candidato.cpf LIKE '$cpf' OR candidato.email LIKE '$email'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();


            $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

            return $totalDeRegistros['Total'] != 0;
        }
    }
}
