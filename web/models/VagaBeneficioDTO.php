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

    public static function recuperar($Vaga, $Beneficio = ''){
        if (empty($Beneficio)) {
            return null;
        }

        $pdo = static::conectarDB();
        $sql = "SELECT * FROM vaga_beneficio ";
        $sql .= "WHERE vaga_id = $Vaga ";
        $sql .= "AND beneficio_id = $Beneficio ";

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
        echo '<pre>';
        var_dump($retorno);
        die();
        return $retorno;
    }

    public static function preencher($dados){
        $Vaga = VagaDTO::recuperar($dados['id']);
        $Beneficio = BeneficioDTO::recuperar($dados['id']);
        $vagaBeneficio = new VagaBeneficio($Vaga, $Beneficio, $dados['informacao']);

        return $vagaBeneficio;
    }
}