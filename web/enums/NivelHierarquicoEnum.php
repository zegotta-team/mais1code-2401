<?php

enum NivelHierarquico: int
{
    case AuxiliarAssistenteAnalista = 1;
    case CoordenacaoSupervisao = 2;
    case Gerencia = 3;
    case Diretoria = 4;
    case CLevel = 5;

    public function label()
    {
        return match($this){
            NivelHierarquico::AuxiliarAssistenteAnalista => 'Auxiliar/Assistente/Analista',
            NivelHierarquico::CoordenacaoSupervisao => 'Coordenação/Supervisão',
            NivelHierarquico::Gerencia => 'Gerência',
            NivelHierarquico::Diretoria => 'Diretoria',
            NivelHierarquico::CLevel => 'C-Level'
        };
    }

    public static function forSelect(): array
    {
        $ids = NivelHierarquico::values();

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