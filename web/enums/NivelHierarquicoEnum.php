<?php

enum NivelHierarquicoEnum: int
{
    case AuxiliarAssistenteAnalista = 1;
    case CoordenacaoSupervisao = 2;
    case Gerencia = 3;
    case Diretoria = 4;
    case CLevel = 5;

    public function label()
    {
        return match($this){
            NivelHierarquicoEnum::AuxiliarAssistenteAnalista => 'Auxiliar/Assistente/Analista',
            NivelHierarquicoEnum::CoordenacaoSupervisao => 'Coordenação/Supervisão',
            NivelHierarquicoEnum::Gerencia => 'Gerência',
            NivelHierarquicoEnum::Diretoria => 'Diretoria',
            NivelHierarquicoEnum::CLevel => 'C-Level'
        };
    }

    public static function forSelect(): array
    {
        $ids = NivelHierarquicoEnum::values();

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