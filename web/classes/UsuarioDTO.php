<?php

abstract class UsuarioDTO
{
    const BANCO = '../db.sqlite';

    public static function salvar(Usuario $usuario)
    {

        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $cpfSoNumero = preg_replace('/\D/', '', $usuario->getCpf());

        if (empty($usuario->getId())) {
//            if (!static::verificaDadosExistentes($usuario->getNome(), $usuario->getCnpj(), $usuario->getUsuario())) {
                $sql = "INSERT INTO usuario(empresa_id, cpf, nome, email, senha)
                    VALUES (\"{$usuario->getEmpresa()->getId()}\", '$cpfSoNumero', \"{$usuario->getNome()}\", \"{$usuario->getEmail()}\", \"{$usuario->getSenha()}\")";
//            } else {
//                return null;
//            }
        } else {
            $sql = "UPDATE usuario SET ";
            $sql .= "empresa_id = '{$usuario->getEmpresa()->getId()}', ";
            $sql .= "cpf = '$cpfSoNumero', ";
            $sql .= "nome = '{$usuario->getNome()}', ";
            $sql .= "email = '{$usuario->getEmail()}', ";
            $sql .= "senha = '{$usuario->getSenha()}' ";
            $sql .= "WHERE id = '{$usuario->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($usuario->getId())) {
            $usuario->setId($pdo->lastInsertId());
        }
    }

    public static function delete(Usuario $usuario)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM usuario WHERE id = {$usuario->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function listarTodos(int $empresaId){
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM usuario WHERE empresa_id = $empresaId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = EmpresaDTO::getById($usuario['empresa_id']);
            $objUsuario = new Usuario($objEmpresa, $usuario['cpf'], $usuario['nome'], $usuario['email'], $usuario['senha']);
            $objUsuario->setId($usuario['id']);
            $retorno[] = $objUsuario;
        }

        return $retorno;
    }

//    public static function verificaDadosExistentes($nome, $cnpj, $usuario)
//    {
//        $diretorio_raiz = dirname(__DIR__);
//        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);
//
//        $pdo = new PDO("sqlite:$caminho_banco");
//        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//        $sql = "SELECT COUNT(1) AS Total FROM empresa ";
//        $sql .= "WHERE empresa.nome LIKE '$nome' OR empresa.cnpj LIKE '$cnpj' OR empresa.usuario LIKE '$usuario'";
//
//        $stmt = $pdo->prepare($sql);
//        $stmt->execute();
//        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        return $totalDeRegistros['Total'] != 0;
//    }

    public static function getById(int $id)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM usuario WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = EmpresaDTO::getById($usuario['empresa_id']);
            $objUsuario = new Usuario($objEmpresa, $usuario['cpf'], $usuario['nome'], $usuario['email'], $usuario['senha']);
            $objUsuario->setId($usuario['id']);
            $retorno = $objUsuario;
        }

        return $retorno;
    }

    public static function autenticar(string $email, string $senha)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = EmpresaDTO::getById($usuario['empresa_id']);
            $objUsuario = new Usuario($objEmpresa, $usuario['cpf'], $usuario['nome'], $usuario['cnpj'], $usuario['usuario']);
            $objUsuario->setId($usuario['id']);
            $retorno = $objUsuario;
        }

        return $retorno;
    }

}
