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
        $sql .= "WHERE vaga_id = {$vagaBeneficio->getVaga()->getId()} ";
        $sql .= "AND beneficio_id = '{$vagaBeneficio->getBeneficio()->getId()}' ";

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

    public static function listar($vagaId = '', $beneficioId = ''){
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM vaga_beneficio vb ";
        $sql .= !empty($beneficioId) ? "LEFT JOIN beneficios b ON vb.beneficio_id = b.id WHERE 1 " : '';
        $sql .= !empty($beneficioId) ? "AND vb.beneficio_id = $beneficioId " : '';
        $sql .= !empty($vagaId) ? "AND vb.vaga_id = $vagaId " : '';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($beneficio);
        }
        
        return $retorno;
    }

    public static function preencher($dados){
        $vaga = VagaDTO::recuperar($dados['vaga_id']);
        $beneficio = BeneficioDTO::recuperar($dados['beneficio_id']);
        $vagaBeneficio = new VagaBeneficio($vaga, $beneficio, $dados['informacao']);

        return $vagaBeneficio;
    }
}
