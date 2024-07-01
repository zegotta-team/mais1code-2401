<?php

enum RegimeContratacaoEnum: int
{
    case Clt = 1;
    case Pj = 2;
    case Estagio = 3;
    case JovemAprendiz = 4;

    public function label(): string
    {
        return match($this){
            RegimeContratacaoEnum::Clt => 'CLT',
            RegimeContratacaoEnum::Pj => 'PJ', 
            RegimeContratacaoEnum::Estagio => 'Estágio',
            RegimeContratacaoEnum::JovemAprendiz => 'Jovem Aprendiz'
        };
    }

    public static function forSelect(): array
    {
        $ids = RegimeContratacaoEnum::values();

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