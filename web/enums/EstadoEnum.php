<?php

enum EstadoEnum: string
{
    case AC = 'AC';
    case AL = 'AL';
    case AP = 'AP';
    case AM = 'AM';
    case BA = 'BA';
    case CE = 'CE';
    case DF = 'DF';
    case ES = 'ES';
    case GO = 'GO';
    case MA = 'MA';
    case MT = 'MT';
    case MS = 'MS';
    case MG = 'MG';
    case PA = 'PA';
    case PB = 'PB';
    case PR = 'PR';
    case PE = 'PE';
    case PI = 'PI';
    case RJ = 'RJ';
    case RN = 'RN';
    case RS = 'RS';
    case RO = 'RO';
    case RR = 'RR';
    case SC = 'SC';
    case SP = 'SP';
    case SE = 'SE';
    case TO = 'TO';

    public function label()
    {
        return match($this){
            EstadoEnum::AC => 'Acre',
            EstadoEnum::AL => 'Alagoas',
            EstadoEnum::AP => 'Amapá',
            EstadoEnum::AM => 'Amazonas',
            EstadoEnum::BA => 'Bahia',
            EstadoEnum::CE => 'Ceará',
            EstadoEnum::DF => 'Distrito Federal',
            EstadoEnum::ES => 'Espírito Santo',
            EstadoEnum::GO => 'Goiás',
            EstadoEnum::MA => 'Maranhão',
            EstadoEnum::MT => 'Mato Grosso',
            EstadoEnum::MS => 'Mato Grosso do Sul',
            EstadoEnum::MG => 'Minas Gerais',
            EstadoEnum::PA => 'Pará',
            EstadoEnum::PB => 'Paraíba',
            EstadoEnum::PR => 'Paraná',
            EstadoEnum::PE => 'Pernambuco',
            EstadoEnum::PI => 'Piauí',
            EstadoEnum::RJ => 'Rio de Janeiro',
            EstadoEnum::RN => 'Rio Grande do Norte',
            EstadoEnum::RS => 'Rio Grande do Sul',
            EstadoEnum::RO => 'Rondônia',
            EstadoEnum::RR => 'Roraima',
            EstadoEnum::SC => 'Santa Catarina',
            EstadoEnum::SP => 'São Paulo',
            EstadoEnum::SE => 'Sergipe',
            EstadoEnum::TO => 'Tocantins'
        };
    }

    public static function forSelect(): array
    {
        $ids = EstadoEnum::values();

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