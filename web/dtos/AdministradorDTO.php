<?php

abstract class AdministradorDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $administrador = new Administrador($dados['nome'], $dados['email'], $dados['login'], $dados['senha'],);
        $administrador->setId($dados['id']);
        return $administrador;
    }

    public static function salvar($administrador)
    {

        $pdo = static::conectarDB();

        if (empty($administrador->getId())) {
            $sql = "INSERT INTO administradores (nome, email, login, senha)
                    VALUES (\"{$administrador->getNome()}\", \"{$administrador->getEmail()}\", \"{$administrador->getLogin()}\", \"{$administrador->getSenha()}\")";
        } else {
            $sql = "UPDATE administradores SET ";
            $sql .= "nome = '{$administrador->getNome()}', ";
            $sql .= "email = '{$administrador->getEmail()}', ";
            $sql .= "login = '{$administrador->getLogin()}' ";
            $sql .= "senha = '{$administrador->getSenha()}' ";
            $sql .= "WHERE id = '{$administrador->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($administrador->getId())) {
            $administrador->setId($pdo->lastInsertId());
        }
    }

    public static function deletar($administrador)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM administradores WHERE id = {$administrador->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($id)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM administradores WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($administrador = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($administrador);
        }

        return $retorno;
    }

    public static function listar()
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM administradores WHERE 1 ";
        $sql .= "ORDER BY nome ASC ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($administrador = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($administrador);;
        }

        return $retorno;
    }

    public static function autenticar(string $login, string $senha)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM administradores WHERE login = '$login' ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($administrador = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($senha, $administrador['senha'])) {
                $retorno = static::preencher($administrador);
            }
        }

        return $retorno;
    }

}
