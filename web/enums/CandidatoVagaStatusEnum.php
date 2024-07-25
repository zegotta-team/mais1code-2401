<?php

enum CandidatoVagaStatusEnum: int
{
    case Desistencia = 0;
    case TriagemDeCurriculos = 1;
    case EntrevistaComRh = 2;
    case EntrevistaTecnica = 3;
    case EntrevistaComGestor = 4;
    case Aprovado = 5;
    case Reprovado = 6;
    case Contratado = 7;
    case RecusouProposta = 8;

    public function label(): string 
    {
        return match ($this) {
            CandidatoVagaStatusEnum::Desistencia => 'Desistência da vaga',
            CandidatoVagaStatusEnum::TriagemDeCurriculos => 'Triagem de currículos',
            CandidatoVagaStatusEnum::EntrevistaComRh => 'Entrevista com RH',
            CandidatoVagaStatusEnum::EntrevistaTecnica => 'Entrevista técnica',
            CandidatoVagaStatusEnum::EntrevistaComGestor => 'Entrevista com gestor',
            CandidatoVagaStatusEnum::Aprovado => 'Aprovado na vaga',
            CandidatoVagaStatusEnum::Reprovado => 'Processo finalizado',
            CandidatoVagaStatusEnum::Contratado => 'Contratado',
            CandidatoVagaStatusEnum::RecusouProposta => 'Recusou a proposta de empresa'
        };
    }

    public static function forSelect(): array
    {
        $ids = CandidatoVagaStatusEnum::values();

        $labels = [];
        foreach (self::cases() as $case) {
            $labels[] = $case->label();
        }
        return array_combine($ids, $labels);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}