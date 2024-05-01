<?php

require_once './class.empresa.php';
require_once './class.vaga.php';
include './funcoes.php';

$empresa = new Empresa(captarNome(), captarCNPJ(), captarUsuario(), captarEmail(), captarSenha(), captarDescricao(), captarLogo(), captarEndereco());
var_dump($empresa);

if (!empty($empresa)) {
    $empresa->salvar();
}

$vaga = new Vaga($empresa, captarTitulo(), captarEmail(), captarSalario(), captarBeneficios(), captarDescricao(), captarRequisitos(), captarCargaHoraria());
var_dump($vaga);

if (!empty($vaga)) {
    $vaga->salvar();
}
