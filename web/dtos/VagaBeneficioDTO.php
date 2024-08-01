<?php

abstract class VagaBeneficioDTO implements DTOInterface
{
    use DbTrait;

    public static function salvar($vagaBeneficio)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM vaga_beneficio WHERE vaga_id = {$vagaBeneficio->getVagaId()} AND beneficio_id = {$vagaBeneficio->getBeneficioId()}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($beneficio);
        }

        if (empty($retorno)) {
            $sql = "INSERT INTO vaga_beneficio (vaga_id, beneficio_id, informacao)
                    VALUES ({$vagaBeneficio->getVagaId()}, {$vagaBeneficio->getBeneficioId()}, \"{$vagaBeneficio->getInformacao()}\")";
        } else {
            $sql = "UPDATE vaga_beneficio SET ";
            $sql .= "informacao = '{$vagaBeneficio->getInformacao()}' ";
            $sql .= "WHERE id = {$vagaBeneficio->getVagaId()} ";
            $sql .= "AND id = {$vagaBeneficio->getBeneficioId()} ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function deletar($vagaBeneficio)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM vaga_beneficio ";
        $sql .= "WHERE vaga_id = {$vagaBeneficio->getVagaId()} ";
        $sql .= "AND beneficio_id = '{$vagaBeneficio->getBeneficioId()}' ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($vaga)
    {

        $pdo = static::conectarDB();
        $sql = "SELECT * FROM vaga_beneficio ";
        $sql .= "WHERE vaga_id = $vaga ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;

        while ($vagaBeneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($vagaBeneficio);
        }

        return $retorno;
    }

    public static function listar($vagaId = '', $beneficioId = '')
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM vaga_beneficio vb ";
        $sql .= !empty($beneficioId) ? "LEFT JOIN beneficios b ON vb.beneficio_id = b.id " : '';
        $sql .= "WHERE 1 ";
        $sql .= !empty($beneficioId) ? "AND vb.beneficio_id = $beneficioId " : '';
        $sql .= !empty($vagaId) ? "AND vb.vaga_id = $vagaId " : '';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($beneficio);
        }

        return $retorno;
    }

    public static function preencher($dados)
    {
        $vagaBeneficio = new VagaBeneficio($dados['vaga_id'], $dados['beneficio_id'], $dados['informacao']);

        return $vagaBeneficio;
    }
}
