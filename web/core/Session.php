<?php

class Session
{

    public static function iniciaSessao()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function exigeSessao(array $tipos = [])
    {
        Session::iniciaSessao();

        $temSessao = false;

        /**
         * @var array<TipoUsuarioEnum> $tipos
         */
        foreach ($tipos as $tipo) {
            if (!empty(Session::get($tipo->session_key()))) {
                $temSessao = true;
                break;
            }
        }

        if (!$temSessao) {
            header("Location: /autenticacao");
        }
    }

    public static function renegaSessao(array $tipos = [])
    {
        Session::iniciaSessao();

        $temSessao = false;
        $sessaoEncontrada = null;

        /**
         * @var array<TipoUsuarioEnum> $tipos
         */
        foreach ($tipos as $tipo) {
            if (Session::estaLogado([$tipo])) {
                $temSessao = true;
                $sessaoEncontrada = $tipo;
                break;
            }
        }

        if ($temSessao) {
            header("Location: {$sessaoEncontrada->home()}");
        }
    }

    public static function destruir()
    {
        Session::iniciaSessao();
        session_destroy();
    }

    public static function estaLogado(array $tipos = [])
    {
        Session::iniciaSessao();

        /**
         * @var array<TipoUsuarioEnum> $tipos
         */
        foreach ($tipos as $tipo) {
            if (!empty(Session::get($tipo->session_key()))) {
                return true;
            }
        }

        return false;
    }

    public static function get($key)
    {
        Session::iniciaSessao();
        return $_SESSION[$key] ?? null;
    }

    public static function set($key, $value): void
    {
        Session::iniciaSessao();
        $_SESSION[$key] = $value;
    }

    public static function clear($key): void
    {
        Session::iniciaSessao();
        unset($_SESSION[$key]);
    }

}
