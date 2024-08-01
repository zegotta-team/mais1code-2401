<?php

class Filial
{

    private $id;
    private Empresa $empresa;
    private $nome;
    private $cep;
    private $logradouro;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;

    public function __construct(Empresa $empresa, $nome, $cep, $logradouro, $numero, $complemento, $bairro, $cidade, $estado)
    {
        $this->setEmpresa($empresa);
        $this->setNome($nome);
        $this->setCep($cep);
        $this->setLogradouro($logradouro);
        $this->setNumero($numero);
        $this->setComplemento($complemento);
        $this->setBairro($bairro);
        $this->setCidade($cidade);
        $this->setEstado($estado);
    }

    public function toArray() {
        return [
            'id' => $this->getId(),
            'empresa' => $this->getEmpresa()->getId(),
            'nome' => $this->getNome(),
            'cep' => $this->getCep(),
            'logradouro' => $this->getLogradouro(),
            'numero' => $this->getNumero(),
            'complemento' => $this->getComplemento(),
            'bairro' => $this->getBairro(),
            'cidade' => $this->getCidade(),
            'estado' => $this->getEstado()
        ];
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

    public function getEmpresa(): Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(Empresa $empresa): Filial
    {
        $this->empresa = $empresa;

        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    public function getLogradouro()
    {
        return $this->logradouro;
    }

    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }

    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;

        return $this;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }
}