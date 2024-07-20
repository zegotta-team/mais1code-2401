<?php

enum NotificacoesStatusEnum: int
{
    case Inativa = 0;
    case NaoLida = 1;
    case Lida = 2;

    public function label(): string 
    {
        return match ($this) {
            NotificacoesStatusEnum::Inativa => 'Deletada',
            NotificacoesStatusEnum::NaoLida => 'Não lida',
            NotificacoesStatusEnum::Lida => 'Lida'
        };
    }

    public static function forSelect(): array
    {
        $ids = NotificacoesStatusEnum::values();

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