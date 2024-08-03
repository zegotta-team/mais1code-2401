<?php

enum CandidatoDisponibilidadeEnum: int
{

    case Imediata = 3;
    case TrintaDias = 2;
    case Parcial = 1;
    case Integral = 0;

    public function label()
    {
        return match ($this) {
            CandidatoDisponibilidadeEnum::Integral => 'Tempo integral',
            CandidatoDisponibilidadeEnum::Parcial => 'Tempo parcial',
            CandidatoDisponibilidadeEnum::TrintaDias => 'Disponível após 30 dias',
            CandidatoDisponibilidadeEnum::Imediata => 'Disponibilidade imediata',
        };
    }

    public static function forSelect(): array
    {
        $ids = CandidatoDisponibilidadeEnum::values();

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