<?php

enum RegimeTrabalhoEnum : int
{
    case Presencial = 1;
    case Hibrido = 2;
    case Remoto = 3;

    public function label(): string
    {
        return match($this){
            RegimeTrabalhoEnum::Presencial => 'Presencial',
            RegimeTrabalhoEnum::Hibrido => 'Híbrido',
            RegimeTrabalhoEnum::Remoto => 'Remoto'
        };
    }

    public static function forSelect(): array
    {
        $ids = RegimeTrabalhoEnum::values();

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