<?php

abstract class EmpresaDTO
{
    const BANCO = '../db.sqlite';

    public static function salvar($empresa)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $cnpjSoNumeros = preg_replace('/\D/', '', $empresa->getCnpj());


        if (empty($empresa->getId())) {
            if (!static::verificaDadosExistentes($empresa->getNome(), $empresa->getCnpj())) {
                $sql = "INSERT INTO empresa(nome, cnpj, email, descricao, logo, endereco)
                    VALUES (\"{$empresa->getNome()}\", '$cnpjSoNumeros', \"{$empresa->getEmail()}\", \"{$empresa->getDescricao()}\", \"{$empresa->getLogo()}\", \"{$empresa->getEndereco()}\")";
            } else {
                echo "<pre>";
                var_dump($empresa);
                die();
            }
        } else {
            $sql = "UPDATE empresa SET ";
            $sql .= "nome = '{$empresa->getNome()}', ";
            $sql .= "cnpj = '$cnpjSoNumeros', ";
            $sql .= "email = '{$empresa->getEmail()}', ";
            $sql .= "descricao = '{$empresa->getDescricao()}', ";
            $sql .= "logo = '{$empresa->getLogo()}', ";
            $sql .= "endereco = '{$empresa->getEndereco()}' ";
            $sql .= "WHERE id = '{$empresa->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $empresa->setId($pdo->lastInsertId());
    }

    public static function delete($empresa)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM vaga WHERE empresa_id = {$empresa->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $sql = "DELETE FROM usuario WHERE empresa_id = {$empresa->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        //todo VagaDTO

        $sql = "DELETE FROM empresa WHERE id = {$empresa->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }


    public static function verificaDadosExistentes($nome, $cnpj)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT COUNT(1) AS Total FROM empresa ";
        $sql .= "WHERE empresa.nome LIKE '$nome' OR empresa.cnpj LIKE '$cnpj'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros['Total'] != 0;
    }

    public static function listaEmpresas($termo = '')
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM empresa ";

        if (!empty($termo)) {
            $sql .= "WHERE cnpj = '$termo' OR nome LIKE '%$termo%' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = new Empresa($empresa['nome'], $empresa['cnpj'], $empresa['email'], $empresa['descricao'], $empresa['logo'], $empresa['endereco']);
            $objEmpresa->setId($empresa['id']);
            $retorno[] = $objEmpresa;
        }

        return $retorno;

    }

    public static function getById($id)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM empresa WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = new Empresa($empresa['nome'], $empresa['cnpj'], $empresa['email'], $empresa['descricao'], $empresa['logo'], $empresa['endereco']);
            $objEmpresa->setId($empresa['id']);
            $retorno = $objEmpresa;
        }

        return $retorno;
    }

    public static function VerificaEmpresa($cnpj)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM empresa WHERE empresa.cnpj LIKE $cnpj";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros;
    }

}
