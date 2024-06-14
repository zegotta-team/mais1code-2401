<?php

enum SexoEnum: string
{
    case Feminino = 'F';
    case Masculino = 'M';

    public function label(): string
    {
        return match ($this) {
            SexoEnum::Feminino => 'Feminino',
            SexoEnum::Masculino => 'Masculino'
        };
    }

    public static function forSelect(): array
    {
        $ids = SexoEnum::values();

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

