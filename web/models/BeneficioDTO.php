<?php

abstract class BeneficioDTO implements DTOInterface
{
    use DbTrait;
    
    public static function preencher($dados)
    {
        $beneficio = new Beneficio($dados['nome']);
        $beneficio->setId($dados['id']);
        return $beneficio;
    }

    public static function salvar($beneficio)
    {
        $pdo = static::conectarDB();

        if (empty($beneficio->getId())) {
            $sql = "INSERT INTO beneficio(nome)
            VALUES (\"{$beneficio->getNome()}\"";
        } else {
            $sql = "UPDATE beneficio SET ";
            $sql .= "nome = '{$beneficio->getNome()}' ";
            $sql .= "WHERE id = '{$beneficio->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function deletar($beneficio)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM beneficio WHERE id = {$beneficio->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($id)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM empresa WHERE id = $id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function listar()
    {
        $pdo = static::conectarDB();
        
        $sql = "SELECT * FROM beneficio";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($beneficio);
        }

        return $retorno;
    }
}