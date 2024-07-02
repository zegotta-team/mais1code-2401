<?php

abstract class FilialDTO implements DTOInterface
{
    use DbTrait;

    public static function verificar($cep, $estado)
    {
        $min = 8;
        $maxUf = 2;

        if (strlen($cep) != $min) {
            FlashMessage::addMessage('Numero de Cep deve conter 8 digitos', FlashMessage::FLASH_ERROR);
            header('Location: /empresa/cadastrar');
            die();
        } elseif ($estado > $maxUf) {
            FlashMessage::addMessage('CPF com quantidade de caracteres não permitida', FlashMessage::FLASH_ERROR);
            header('Location: /empresa/cadastrar');
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
