<?php

echo "digite o cpf:";
$cpf = fgets(STDIN);
echo "digite o email:";
$email = fgets(STDIN);

$email = "exemplo@exemplo";

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "O e-mail é válido.";
} else {
    echo "O e-mail é inválido.";
}

$min = "0";
        $maxemail = 30;
        $maxcpf = 11;
        if (strlen($cpf) != $maxcpf || strlen($email) < $min || strlen($email) > $maxemail) {
        echo "CPF ou Email com numero de caracteres invalido";
        } else { echo "o cpf e email passaram!"; }