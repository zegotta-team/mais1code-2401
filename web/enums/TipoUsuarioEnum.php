<?php

enum TipoUsuarioEnum: int
{
    case EMPRESA = 2;
    case ADMINISTRADOR = 1;
    case CANDIDATO = 0;

    public function session_key(): string
    {
        return match ($this) {
            TipoUsuarioEnum::ADMINISTRADOR => 'administrador',
            TipoUsuarioEnum::EMPRESA => 'usuario',
            TipoUsuarioEnum::CANDIDATO => 'candidato'
        };
    }

    public function home(): string
    {
        return match ($this) {
            TipoUsuarioEnum::ADMINISTRADOR, TipoUsuarioEnum::CANDIDATO => '/',
            TipoUsuarioEnum::EMPRESA => '/vaga/painel'
        };
    }

    public function login_tab(): int
    {
        return match ($this) {
            TipoUsuarioEnum::ADMINISTRADOR => 3,
            TipoUsuarioEnum::EMPRESA => 2,
            TipoUsuarioEnum::CANDIDATO => 1
        };
    }


}