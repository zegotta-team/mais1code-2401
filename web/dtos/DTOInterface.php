<?php

interface DTOInterface {

    public static function salvar($instancia);

    public static function deletar($instancia);

    public static function recuperar($id);

    public static function listar();

    public static function preencher($dados);

}