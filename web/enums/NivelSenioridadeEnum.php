<?php

enum NivelSenioridadeEnum: int
{
    case Junior = 1;
    case Pleno = 2;
    case Senior = 3;

    public function label(): string
    {
        return match($this){
            NivelSenioridadeEnum::Junior => 'Júnior',
            NivelSenioridadeEnum::Pleno => 'Pleno',
            NivelSenioridadeEnum::Senior => 'Sênior'
        
        };
    }
    
    public static function forSelect(): array
    {
        $ids = NivelSenioridadeEnum::values();

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