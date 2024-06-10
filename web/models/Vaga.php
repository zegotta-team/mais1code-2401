<?php

class Vaga
{
    private $id;
    private Empresa $empresa;
    private $titulo;
    private $email;
    private $salario;
    private $beneficios;
    private $descricao;
    private $requisitos;
    private $cargaHoraria;
    private $status;

    public function __construct($empresa, $titulo, $email, $salario, $beneficios, $descricao, $requisitos, $cargaHoraria, $status)
    {
        $this->setEmpresa($empresa);
        $this->setTitulo($titulo);
        $this->setEmail($email);
        $this->setSalario($salario);
        $this->setBeneficios($beneficios);
        $this->setDescricao($descricao);
        $this->setRequisitos($requisitos);
        $this->setCargaHoraria($cargaHoraria);
        $this->setStatus($status);
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

    public function getEmpresa()
    {
        return $this->empresa;
    }

    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
        return $this;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function getTitulo()
    {
        return ucwords($this->titulo);
    }

    public function setEmail($Email)
    {
        $this->email = $Email;
        return $this;
    }

    public function getEmail()
    {
        return strtolower($this->email);
    }

    public function setSalario($salario)
    {
        $this->salario = $salario;
        return $this;
    }

    public function getSalario()
    {
        return $this->salario;
    }

    public function setBeneficios($Beneficios)
    {
        $this->beneficios = $Beneficios;
        return $this;
    }

    public function getBeneficios()
    {
        return $this->beneficios;
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

    public function setRequisitos($Requisitos)
    {
        $this->requisitos = $Requisitos;
        return $this;
    }

    public function getRequisitos()
    {
        return $this->requisitos;
    }

    public function setCargaHoraria($CargaHoraria)
    {
        $this->cargaHoraria = $CargaHoraria;
        return $this;
    }

    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    public function getStatus($formatado = false)
    {
        if ($formatado) {
            return $this->status === 0 ? 'Inativa' : 'Ativa';
        } else {
            return $this->status;
        }
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function cardFormatado()
    {
        return "
                <div class='d-flex justify-content-between h-100 flex-column'>   
                    <div>
                        <div class='titulo ps-2 pe-2 align-items-center d-flex justify-content-between'>
                            <strong><a href='/vaga/exibir/?id={$this->getId()}'>{$this->getTitulo()}</a></strong>
                            <i class='fas fa-thumbtack'></i>
                        </div>
                        <div class='p-2'>  
                            <p><i class='fas fa-building text-muted'></i> <small>{$this->getEmpresa()->getNome()}</small></p>
                            <p><i class='fas fa-medal text-muted'></i> {$this->getRequisitos()}</p>
                            <p><i class='fas fa-coins text-muted'></i> R$ {$this->getSalario()}</p>
                        </div>
                    </div>
                    <div class='ver-mais ps-2 pe-2 text-end d-flex justify-content-end align-items-baseline'>
                        <a href='/vaga/exibir/?id={$this->getId()}' class='mt-auto'>Ver mais <i class='far fa-arrow-alt-circle-right'></i></a>
                    </div>
                </div>";


    }
}