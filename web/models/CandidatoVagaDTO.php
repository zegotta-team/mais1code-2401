<?php
abstract class CandidatoVagaDTO implements DTOInterface
{
    use DbTrait;

    public static function preecher($dados)
    {
        $candidato = CandidatoDTO::recuperar($dados['candidato_id']);
        $vaga = VagaDTO::recuperar($dados['vaga_id']);
        $candidatoVaga = new CandidatoVaga($candidato, $vaga, $dados['ultima_desistencia'], $dados['status']);

        return $candidatoVaga;
    }
}