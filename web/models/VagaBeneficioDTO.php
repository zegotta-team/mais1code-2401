<?php

abstract class VagaBeneficioDTO implements DTOInterface
{
    use DbTrait;

    public static function salvar($vagaBeneficio){
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM vaga_beneficio WHERE vaga_id = {$vagaBeneficio->getVagaId()} AND beneficio_id = {$vagaBeneficio->getBeneficioId()}";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($beneficio);
        }

        if (empty($retorno)) {
            $sql = "INSERT INTO vaga_beneficio (vaga_id, beneficio_id, informacao)
                    VALUES ({$vagaBeneficio->getVaga()->getId()}, 
                            {$vagaBeneficio->getBeneficio()->getId()}, 
                            \"{$vagaBeneficio->getInformacao()}\")";
        } else {
            $sql = "UPDATE vaga_beneficio SET ";
            $sql .= "informacao = '{$vagaBeneficio->getInformacao()}' ";
            $sql .= "WHERE id = {$vagaBeneficio->getVaga()->getId()} ";
            $sql .= "AND id = {$vagaBeneficio->getBeneficio()->getId()} ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function deletar($vagaBeneficio)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM vaga_beneficio ";
        $sql .= "WHERE vaga_id = {$vagaBeneficio->getVagaId()} ";
        $sql .= "AND beneficio_id = {$vagaBeneficio->getBeneficioId()} ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($vagaId, $beneficioId = ''){
        if (empty($beneficioId)) {
            return null;
        }

        $pdo = static::conectarDB();
        $sql = "SELECT * FROM vaga_beneficio ";
        $sql .= "WHERE vaga_id = $vagaId ";
        $sql .= "AND beneficio_id = $beneficioId ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        
        while ($vagaBeneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($vagaBeneficio);
        }

        return $retorno;
    }

    public static function listar(){
        $pdo = static::conectarDB();

        $sql = "SELECT * ";
        $sql .= "FROM vaga_beneficio ";
        $sql .= "LEFT JOIN beneficios b ";
        $sql .= "ON b.id = beneficio_id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($beneficio);
        }

        return $retorno;
    }

    public static function preencher($dados){
        $vagaId = VagaDTO::recuperar($dados['id']);
        $beneficioId = BeneficioDTO::recuperar($dados['id']);
        $vagaBeneficio = new VagaBeneficio($vagaId, $beneficioId, $dados['informacao']);

        return $vagaBeneficio;
    }
}