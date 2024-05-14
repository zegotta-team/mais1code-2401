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
            if (!static::verificaDadosExistentes($empresa->getNome(), $empresa->getCnpj(), $empresa->getUsuario())) {
                $sql = "INSERT INTO empresa(nome, cnpj, usuario, email, senha, descricao, logo, endereco)
                    VALUES (\"{$empresa->getNome()}\", '$cnpjSoNumeros', \"{$empresa->getUsuario()}\", \"{$empresa->getEmail()}\", \"{$empresa->getSenha()}\", \"{$empresa->getDescricao()}\", \"{$empresa->getLogo()}\", \"{$empresa->getEndereco()}\")";
            } else {
                return null;
            }
        } else {
            $sql = "UPDATE empresa SET ";
            $sql .= "nome = '{$empresa->getNome()}', ";
            $sql .= "cnpj = '$cnpjSoNumeros', ";
            $sql .= "usuario = '{$empresa->getUsuario()}', ";
            $sql .= "email = '{$empresa->getEmail()}', ";
            $sql .= "senha = '{$empresa->getSenha()}', ";
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
        //todo VagaDTO

        $sql = "DELETE FROM empresa WHERE id = {$empresa->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }


    public static function verificaDadosExistentes($nome, $cnpj, $usuario)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT COUNT(1) AS Total FROM empresa ";
        $sql .= "WHERE empresa.nome LIKE '$nome' OR empresa.cnpj LIKE '$cnpj' OR empresa.usuario LIKE '$usuario'";

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
            $objEmpresa = new Empresa($empresa['nome'], $empresa['cnpj'], $empresa['usuario'], $empresa['email'], $empresa['senha'], $empresa['descricao'], $empresa['logo'], $empresa['endereco']);
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
            $objEmpresa = new Empresa($empresa['nome'], $empresa['cnpj'], $empresa['usuario'], $empresa['email'], $empresa['senha'], $empresa['descricao'], $empresa['logo'], $empresa['endereco']);
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

    public static function autenticar($usuario, $senha)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM empresa WHERE usuario = '$usuario' AND senha = '$senha'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = new Empresa($empresa['nome'], $empresa['cnpj'], $empresa['usuario'], $empresa['email'], $empresa['senha'], $empresa['descricao'], $empresa['logo'], $empresa['endereco']);
            $objEmpresa->setId($empresa['id']);
            $retorno = $objEmpresa;
        }
        return $retorno;
    }

}