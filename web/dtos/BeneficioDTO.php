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
            $sql = "INSERT INTO beneficios(nome) VALUES (\"{$beneficio->getNome()}\")";
        } else {
            $sql = "UPDATE beneficios SET ";
            $sql .= "nome = '{$beneficio->getNome()}' ";
            $sql .= "WHERE id = '{$beneficio->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function deletar($beneficio)
    {
        $pdo = static::conectarDB();

        foreach (VagaBeneficioDTO::listar('', $beneficio->getId()) as $vagaBeneficio) {
            VagaBeneficioDTO::deletar($vagaBeneficio);
        }

        if (!empty($beneficio->getId())) {
            $sql = "DELETE FROM candidato_beneficio WHERE beneficio_id = '{$beneficio->getId()}'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }

        $sql = "DELETE FROM beneficios WHERE id = '{$beneficio->getId()}'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($id)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM beneficios WHERE id = $id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($beneficio);
        }
        
        return $retorno;
    }

    public static function listar()
    {
        $pdo = static::conectarDB();
        
        $sql = "SELECT * FROM beneficios ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($beneficio);
        }

        return $retorno;
    }
}