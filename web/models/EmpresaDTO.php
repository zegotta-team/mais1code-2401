<?php

abstract class EmpresaDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $empresa = new Empresa($dados['nome'], $dados['cnpj'], $dados['email'], $dados['descricao'], $dados['logo'], $dados['endereco']);
        $empresa->setId($dados['id']);
        return $empresa;
    }

    public static function salvar($empresa)
    {
        $pdo = static::conectarDB();

        $cnpjSoNumeros = preg_replace('/\D/', '', $empresa->getCnpj());

        if (empty($empresa->getId())) {
            if (!static::verificaDadosExistentes($empresa->getNome(), $empresa->getCnpj())) {
                $sql = "INSERT INTO empresa(nome, cnpj, email, descricao, logo, endereco)
                    VALUES (\"{$empresa->getNome()}\", '$cnpjSoNumeros', \"{$empresa->getEmail()}\", \"{$empresa->getDescricao()}\", \"{$empresa->getLogo()}\", \"{$empresa->getEndereco()}\")";
            } else {
                echo "<pre>";
                var_dump($empresa);
                die();
            }
        } else {
            $sql = "UPDATE empresa SET ";
            $sql .= "nome = '{$empresa->getNome()}', ";
            $sql .= "cnpj = '$cnpjSoNumeros', ";
            $sql .= "email = '{$empresa->getEmail()}', ";
            $sql .= "descricao = '{$empresa->getDescricao()}', ";
            $sql .= "logo = '{$empresa->getLogo()}', ";
            $sql .= "endereco = '{$empresa->getEndereco()}' ";
            $sql .= "WHERE id = '{$empresa->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($empresa->getId())) {
            $empresa->setId($pdo->lastInsertId());
        }
    }

    public static function deletar($empresa)
    {
        $pdo = static::conectarDB();

        foreach (VagaDTO::listar($empresa->getId()) as $vaga) {
            VagaDTO::deletar($vaga);
        }

        foreach (UsuarioDTO::listar($empresa->getId()) as $usuario) {
            UsuarioDTO::deletar($usuario);
        }

        $sql = "DELETE FROM empresa WHERE id = {$empresa->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($id)
    {
        $pdo = static::conectarDB();
        $sql = "SELECT * FROM empresa WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($empresa);
        }

        return $retorno;
    }

    public static function listar($termo = '')
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM empresa ";

        if (!empty($termo)) {
            $sql .= "WHERE cnpj = '$termo' OR nome LIKE '%$termo%' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($empresa);
        }

        return $retorno;

    }

    private static function verificaDadosExistentes($nome, $cnpj)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT COUNT(1) AS Total FROM empresa ";
        $sql .= "WHERE empresa.nome LIKE '$nome' OR empresa.cnpj LIKE '$cnpj'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros['Total'] != 0;
    }

}
