<?php

class Empresa
{
    const BANCO = 'db.sqlite';

    private $id;
    private $nome;
    private $cnpj;
    private $usuario;
    private $email;
    private $senha;
    private $descricao;
    private $logo;
    private $endereco;

    public function __construct($nome, $cnpj, $usuario, $email, $senha, $descricao, $logo, $endereco)
    {
        $this->setNome($nome);
        $this->setCNPJ($cnpj);
        $this->setUsuario($usuario);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setDescricao($descricao);
        $this->setLogo($logo);
        $this->setEndereco($endereco);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setNome($Nome)
    {
        $this->nome = $Nome;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setCNPJ($Cnpj)
    {
        $this->cnpj = $Cnpj;
        return $this;
    }

    public function getCNPJ()
    {
        return $this->cnpj;
    }

    public function setUsuario($Usuario)
    {
        $this->usuario = $Usuario;
        return $this;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setEmail($Email)
    {
        $this->email = $Email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setSenha($Senha)
    {
        $this->senha = $Senha;
        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setDescricao($Descricao)
    {
        $this->descricao = $Descricao;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setLogo($Logo)
    {
        $this->logo = $Logo;
        return $this;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setEndereco($Endereco)
    {
        $this->endereco = $Endereco;
        return $this;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function salvar()
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $cnpjSoNumeros = preg_replace('/\D/', '', $this->cnpj);

        if (empty($this->id)) {
            $sql = "INSERT INTO empresa(nome, cnpj, usuario, email, senha, descricao, logo, endereco)
                    VALUES (\"$this->nome\", '$cnpjSoNumeros', \"$this->usuario\", \"$this->email\", \"$this->senha\", \"$this->descricao\", \"$this->logo\", \"$this->endereco\")";
        } else {
            $sql = "UPDATE empresa SET ";
            $sql .= "nome = '$this->nome', ";
            $sql .= "cnpj = '$cnpjSoNumeros', ";
            $sql .= "usuario = '$this->usuario', ";
            $sql .= "email = '$this->email', ";
            $sql .= "senha = '$this->senha', ";
            $sql .= "descricao = '$this->descricao', ";
            $sql .= "logo = '$this->logo', ";
            $sql .= "endereco = '$this->endereco' ";
            $sql .= "WHERE id = '$this->id' ";
        }
        echo $sql;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $this->id = $pdo->lastInsertId();
    }

    public function delete()
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM vaga WHERE empresa_id = {$this->id}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $sql = "DELETE FROM empresa WHERE id = {$this->id}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function verificaDadosExistentes($nome, $cnpj, $usuario)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT COUNT(1) AS Total FROM empresa ";
        $sql .= "WHERE empresa.nome LIKE '$nome' OR empresa.cnpj LIKE '$cnpj' OR empresa.usuario LIKE '$usuario'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros['Total'] != 0;
    }

    public static function listaEmpresas($termo = '')
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM empresa ";

        if (!empty($termo)) {
            $sql .= "WHERE cnpj = '$termo' OR nome LIKE '%$termo%' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = new Empresa($empresa['nome'], $empresa['cnpj'], $empresa['usuario'], $empresa['email'], $empresa['senha'], $empresa['descricao'], $empresa['logo'], $empresa['endereco']);
            $objEmpresa->setId($empresa['id']);
            $retorno[] = $objEmpresa;
        }

        return $retorno;

    }

    public static function getById($id)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM empresa WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = new Empresa($empresa['nome'], $empresa['cnpj'], $empresa['usuario'], $empresa['email'], $empresa['senha'], $empresa['descricao'], $empresa['logo'], $empresa['endereco']);
            $objEmpresa->setId($empresa['id']);
            $retorno = $objEmpresa;
        }

        return $retorno;
    }

    public static function VerificaEmpresa($cnpj)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM empresa WHERE empresa.cnpj LIKE $cnpj";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros;
    }

    public static function autenticar($usuario, $senha)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM empresa WHERE usuario = '$usuario' AND senha = '$senha'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($empresa = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = new Empresa($empresa['nome'], $empresa['cnpj'], $empresa['usuario'], $empresa['email'], $empresa['senha'], $empresa['descricao'], $empresa['logo'], $empresa['endereco']);
            $objEmpresa->setId($empresa['id']);
            $retorno = $objEmpresa;
        }
        return $retorno;
    }

}
