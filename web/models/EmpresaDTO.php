<?php

abstract class EmpresaDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $empresa = new Empresa($dados['nome'], $dados['cnpj'], $dados['email'], $dados['descricao'], $dados['logo']);
        $empresa->setId($dados['id']);
        return $empresa;
    }

    public static function salvar($empresa)
    {
        $pdo = static::conectarDB();

        $cnpjSoNumeros = preg_replace('/\D/', '', $empresa->getCnpj());

        if (empty($empresa->getId())) {
            $sql = "INSERT INTO empresa(nome, cnpj, email, descricao, logo)
            VALUES (\"{$empresa->getNome()}\", '$cnpjSoNumeros', \"{$empresa->getEmail()}\", \"{$empresa->getDescricao()}\", \"{$empresa->getLogo()}\")";
        } else {
            $sql = "UPDATE empresa SET ";
            $sql .= "nome = '{$empresa->getNome()}', ";
            $sql .= "cnpj = '$cnpjSoNumeros', ";
            $sql .= "email = '{$empresa->getEmail()}', ";
            $sql .= "descricao = '{$empresa->getDescricao()}', ";
            $sql .= "logo = '{$empresa->getLogo()}' ";
            $sql .= "WHERE id = '{$empresa->getId()}' ";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($empresa->getId())) {
            $empresa->setId($pdo->lastInsertId());
        }

        if (str_starts_with($empresa->getLogo(), '/tmp')) {
            static::processaImagemEnviada($empresa, $pdo);
        }
    }

    private static function processaImagemEnviada(Empresa $empresa, PDO $pdo)
    {
        $partesArquivoTemporario = explode('|', $empresa->getLogo());
        $nomeArquivoTemporario = $partesArquivoTemporario[0];
        $nomeArquivoOriginal = $partesArquivoTemporario[1];

        $extensao = explode('.', $nomeArquivoOriginal);
        $nomeArquivoPersistido = uniqid() . "." . end($extensao);

        $caminhoRelativoPasta = '/assets/images/empresa/' . $empresa->getId();
        $caminhoAbsolutoPasta = dirname(__DIR__) . $caminhoRelativoPasta;

        if (!file_exists($caminhoAbsolutoPasta)) {
            mkdir($caminhoAbsolutoPasta, 0777);
        }

        $caminhoRelativoArquivo = "$caminhoRelativoPasta/$nomeArquivoPersistido";
        $caminhoAbsolutoArquivo = "$caminhoAbsolutoPasta/$nomeArquivoPersistido";

        if (move_uploaded_file($nomeArquivoTemporario, $caminhoAbsolutoArquivo)) {
            $sql = "UPDATE empresa SET logo = '$caminhoRelativoArquivo' WHERE id = '{$empresa->getId()}' ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
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

    public static function verificaDadosExistentes($nome, $cnpj)
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
