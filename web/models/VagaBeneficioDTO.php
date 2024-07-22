<?php

abstract class VagaBeneficioDTO implements DTOInterface
{
    use DbTrait;

    public static function salvar($vagaBeneficio){
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM vaga_beneficio WHERE vaga_id = {$vagaBeneficio->getVaga()} AND beneficio_id = {$vagaBeneficio->getBeneficio()}";
        
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
        $sql .= "WHERE vaga_id = {$vagaBeneficio->getVaga()} ";
        $sql .= "AND beneficio_id = {$vagaBeneficio->getBeneficio()} ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($vaga, $beneficio = ''){
        if (empty($beneficio)) {
            return null;
        }

        $pdo = static::conectarDB();
        $sql = "SELECT * FROM vaga_beneficio ";
        $sql .= "WHERE vaga_id = $vaga ";
        $sql .= "AND beneficio_id = $beneficio ";

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
        $vaga = VagaDTO::recuperar($dados['id']);
        $beneficio = BeneficioDTO::recuperar($dados['id']);
        $vagaBeneficio = new VagaBeneficio($vaga, $beneficio, $dados['informacao']);

        return $vagaBeneficio;
    }
}
