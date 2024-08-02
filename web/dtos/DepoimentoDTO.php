<?php

abstract class DepoimentoDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $depoimento = new Depoimento($dados['empresa_id'], $dados['candidato_id'], $dados['depoimento'], $dados['avaliacao']);
        $depoimento->setId($dados['id']);
        return $depoimento;
    }

    public static function salvar($depoimento)
    {
        $pdo = static::conectarDB();

        if (empty($depoimento->getId())) {
            $sql = "INSERT INTO depoimentos (empresa_id, candidato_id, depoimento, avaliacao) 
            VALUES ({$depoimento->getEmpresaId()}, {$depoimento->getCandidatoId()}, \"{$depoimento->getDepoimento()}\", {$depoimento->getAvaliacao()})";
        } else {
            $sql = "UPDATE depoimentos SET ";
            $sql .= "empresa_id = '{$depoimento->getEmpresaId()}', ";
            $sql .= "candidato_id = '{$depoimento->getCandidatoId()}', ";
            $sql .= "depoimento = '{$depoimento->getDepoimento()}', ";
            $sql .= "avaliacao = '{$depoimento->getAvaliacao()}' ";
            $sql .= "WHERE id = '{$depoimento->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function deletar($depoimento)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM depoimentos WHERE id = '{$depoimento->getId()}'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($id)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM depoimentos WHERE id = $id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($depoimento = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($depoimento);
        }

        return $retorno;
    }

    public static function listar($empresa_id = '', $candidato_id = '')
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM depoimentos ";
        $sql .= "WHERE 1 ";
        $sql .= !empty($empresa_id) ? "AND empresa_id = '{$empresa_id}' " : "";
        $sql .= !empty($candidato_id) ? "AND candidato_id = '{$candidato_id}' " : "";
        $sql .= "ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($depoimento = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($depoimento);
        }

        return $retorno;
    }
}