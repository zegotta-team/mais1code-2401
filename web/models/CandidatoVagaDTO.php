<?php

abstract class CandidatoVagaDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $candidato = CandidatoDTO::recuperar($dados['candidato_id']);
        $vaga = VagaDTO::recuperar($dados['vaga_id']);
        $candidatoVaga = new CandidatoVaga($candidato, $vaga, $dados['ultima_desistencia'], $dados['status']);

        return $candidatoVaga;
    }

    public static function salvar($candidatoVaga)
    {
        $pdo = static::conectarDB();

        if (empty($candidatoVaga->getCandidato()->getId()) && empty($candidatoVaga->getVaga()->getId())) {
            $sql = "INSERT INTO candidato_vaga (candidato_id, vaga_id, ultima_desistencia, `status`) 
                    VALUES ({$candidatoVaga->getCandidato()->getId()}, {$candidatoVaga->getVaga()->getId()}, \"{$candidatoVaga->getUltimaDesistencia()}\", \"{$candidatoVaga->getStatus()}\")";
        } else {
            $sql = "UPDATE candidato_vaga SET ";
            $sql .= "ultima_desistencia = \"{$candidatoVaga->getUltimaDesistencia()}\", ";
            $sql .= "`status` = \"{$candidatoVaga->getStatus()}\" ";
            $sql .= " WHERE candidato_id = {$candidatoVaga->getCandidato()->getId()} AND vaga_id = {$candidatoVaga->getVaga()->getId()} ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($candidato_id, $vaga_id = '')
    {
        if (empty($vaga_id)) {
            return null;
        }

        $pdo = static::conectarDB();
        $sql = "SELECT * FROM candidato_vaga WHERE candidato_id = $candidato_id AND vaga_id = $vaga_id";


        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($candidatoVaga = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($candidatoVaga);
        }

        return $retorno;
    }

    public static function listar($candidato_id = '', $vaga_id = '', $status = '')
    {
        $pdo = static::conectarDB();
        $sql = "SELECT candidato_vaga.*, vaga.* 
                FROM candidato_vaga 
                INNER JOIN vaga ON id  = candidato_vaga.vaga_id 
                WHERE 1 ";
        $sql .= !empty($candidato_id) ? "AND candidato_vaga.candidato_id = $candidato_id " : '';
        $sql .= !empty($vaga_id) ? "AND candidato_vaga.vaga_id = $vaga_id " : '';
        $sql .= !empty($status) ? "AND candidato_vaga.status = $status " : '';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($candidatoVaga = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($candidatoVaga);
        }
        return $retorno;
    }
}