<?php

enum PropostaStatusEnum: int
{
    case Aguardando = 0;
    case Aceita = 1;
    case Rejeitada = 2;

    public function label(): string
    {
        return match ($this) {
            PropostaStatusEnum::Aguardando => 'Aguardando',
            PropostaStatusEnum::Aceita => 'Aceita',
            PropostaStatusEnum::Rejeitada => 'Rejeitada'
        };
    }

    public static function forSelect(): array
    {
        $ids = PropostaStatusEnum::values();

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