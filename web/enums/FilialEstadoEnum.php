<?php

enum FilialEstadoEnum: int
{
    case AC = 1;
    case AL = 2;
    case AP = 3;
    case AM = 4;
    case BA = 5;
    case CE = 6;
    case DF = 7;
    case ES = 8;
    case GO = 9;
    case MA = 10;
    case MT = 11;
    case MS = 12;
    case MG = 13;
    case PA = 14;
    case PB = 15;
    case PR = 16;
    case PE = 17;
    case PI = 18;
    case RJ = 19;
    case RN = 20;
    case RS = 21;
    case RO = 22;
    case RR = 23;
    case SC = 24;
    case SP = 25;
    case SE = 26;
    case TO = 27;

    public function label()
    {
        return match($this){
            FilialEstadoEnum::AC => 'Acre',
            FilialEstadoEnum::AL => 'Alagoas',
            FilialEstadoEnum::AP => 'Amapá',
            FilialEstadoEnum::AM => 'Amazonas',
            FilialEstadoEnum::BA => 'Bahia',
            FilialEstadoEnum::CE => 'Ceará',
            FilialEstadoEnum::DF => 'Distrito Federal',
            FilialEstadoEnum::ES => 'Espírito Santo',
            FilialEstadoEnum::GO => 'Goiás',
            FilialEstadoEnum::MA => 'Maranhão',
            FilialEstadoEnum::MT => 'Mato Grosso',
            FilialEstadoEnum::MS => 'Mato Grosso do Sul',
            FilialEstadoEnum::MG => 'Minas Gerais',
            FilialEstadoEnum::PA => 'Pará',
            FilialEstadoEnum::PB => 'Paraíba',
            FilialEstadoEnum::PR => 'Paraná',
            FilialEstadoEnum::PE => 'Pernambuco',
            FilialEstadoEnum::PI => 'Piauí',
            FilialEstadoEnum::RJ => 'Rio de Janeiro',
            FilialEstadoEnum::RN => 'Rio Grande do Norte',
            FilialEstadoEnum::RS => 'Rio Grande do Sul',
            FilialEstadoEnum::RO => 'Rondônia',
            FilialEstadoEnum::RR => 'Roraima',
            FilialEstadoEnum::SC => 'Santa Catarina',
            FilialEstadoEnum::SP => 'São Paulo',
            FilialEstadoEnum::SE => 'Sergipe',
            FilialEstadoEnum::TO => 'Tocantins'
        };
    }

    public static function forSelect(): array
    {
        $ids = FilialEstadoEnum::values();

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