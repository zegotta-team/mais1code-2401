<?php

abstract class FilialDTO implements DTOInterface
{
    use DbTrait;

    public static function salvar($filial)
    {
        $pdo = static::conectarDB();

        $cepSoNumero = preg_replace('/\D/', '', $filial->getCep());

        if (empty($filial->getId())) {
            $sql = "INSERT INTO filial (empresa_id, nome, cep, logradouro, numero, complemento, bairro, cidade, estado)
                VALUES (\"{$filial->getEmpresa()->getId()}\", \"{$filial->getnome()}\" ,'$cepSoNumero', \"{$filial->getLogradouro()}\", \"{$filial->getNumero()}\", \"{$filial->getComplemento()}\", \"{$filial->getBairro()}\", \"{$filial->getCidade()}\", \"{$filial->getEstado()}\")";
        } else {
            $sql = "UPDATE filial SET ";
            $sql .= "empresa_id = '{$filial->getEmpresa()->getId()}', ";
            $sql .= "nome = '{$filial->getNome()}', ";
            $sql .= "cep = '$cepSoNumero', ";
            $sql .= "logradouro = '{$filial->getLogradouro()}', ";
            $sql .= "numero = '{$filial->getNumero()}', ";
            $sql .= "complemento = '{$filial->getComplemento()}', ";
            $sql .= "bairro = '{$filial->getBairro()}', ";
            $sql .= "cidade = '{$filial->getCidade()}', ";
            $sql .= "estado = '{$filial->getEstado()}', ";
            $sql .= " WHERE filial_id = {$filial->getId()} ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($filial->getId())) {
            $filial->setId($pdo->lastInsertId());
        }
    }

    public static function deletar($filial)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM filial WHERE id = {$filial->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function listar($empresa_id = '', $filial_id = '')
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM filial WHERE 1 ";
        $sql .= !empty($empresa_id) ? "AND filial.empresa_id = $empresa_id " : '';
        $sql .= !empty($filial_id) ? "AND filial.id = $filial_id " : '';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($filial = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($filial);
        }
        return $retorno;
    }

    public static function preencher($dados)
    {
        $empresa = EmpresaDTO::recuperar($dados['empresa_id']);
        $filial = new Filial($empresa, $dados['nome'], $dados['cep'], $dados['logradouro'], $dados['numero'], $dados['complemento'], $dados['bairro'], $dados['cidade'], $dados['estado']);
        $filial->setId($dados['id']);
        return $filial;
    }

    public static function verificar($cep, $estado)
    {
        $min = 8;
        $maxUf = 2;

        if (strlen($cep) != $min) {
            FlashMessage::addMessage('Numero de Cep deve conter 8 digitos', FlashMessage::FLASH_ERROR);
            header('Location: /empresa/cadastrar');
            die();
        } elseif (strlen($estado) != $maxUf) {
            FlashMessage::addMessage('Numero de UF deve conter 2 digitos', FlashMessage::FLASH_ERROR);
            header('Location: /empresa/cadastrar');
            die();
        }
        return true;
    }
}
