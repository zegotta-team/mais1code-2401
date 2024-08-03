<?php

enum CandidatoGeneroEnum: string
{

    case Cisgenero = 'C';
    case Transgenero = 'T';
    case Outro = 'O';

    public function label()
    {
        return match ($this) {
            CandidatoGeneroEnum::Cisgenero => 'Cisgênero',
            CandidatoGeneroEnum::Transgenero => 'Transgênero',
            CandidatoGeneroEnum::Outro => 'Outro',
        };
    }

    public static function forSelect(): array
    {
        $ids = CandidatoGeneroEnum::values();

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