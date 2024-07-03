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
    private $cargaHoraria;
    private $regimeContratacao;
    private $regimeTrabalho;
    private $nivelSenioridade;
    private $nivelHierarquico;
    private $status;
    private $habilidades;

    public function __construct($empresa, $titulo, $email, $salario, $beneficios, $descricao, $cargaHoraria, $regimeContratacao, $regimeTrabalho, $nivelSenioridade, $nivelHierarquico, $status, $habilidades)
    {
        $this->setEmpresa($empresa);
        $this->setTitulo($titulo);
        $this->setEmail($email);
        $this->setSalario($salario);
        $this->setBeneficios($beneficios);
        $this->setDescricao($descricao);
        $this->setCargaHoraria($cargaHoraria);
        $this->setRegimeContratacao($regimeContratacao);
        $this->setRegimeTrabalho($regimeTrabalho);
        $this->setNivelSenioridade($nivelSenioridade);
        $this->setNivelHierarquico($nivelHierarquico);
        $this->setStatus($status);
        $this->setHabilidades($habilidades);
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

    public function setCargaHoraria($CargaHoraria)
    {
        $this->cargaHoraria = $CargaHoraria;
        return $this;
    }

    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    public function setRegimeContratacao($RegimeContratacao)
    {
        $this->regimeContratacao = $RegimeContratacao;
        return $this;
    }    
    
    public function getRegimeContratacao()
    {
        return $this->regimeContratacao;
    }

    public function setRegimeTrabalho($RegimeTrabalho)
    {
        $this->regimeTrabalho = $RegimeTrabalho;
        return $this;
    }    
    
    public function getRegimeTrabalho()
    {
        return $this->regimeTrabalho;
    }

    public function setNivelSenioridade($NivelSenioridade)
    {
        $this->nivelSenioridade = $NivelSenioridade;
        return $this;
    }    
    
    public function getNivelSenioridade()
    {
        return $this->nivelSenioridade;
    }

    public function setNivelHierarquico($NivelHierarquico)
    {
        $this->nivelHierarquico = $NivelHierarquico;
        return $this;
    }    
    
    public function getNivelHierarquico()
    {
        return $this->nivelHierarquico;
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

    public function getHabilidades(){
        return $this->habilidades;
    }

    public function setHabilidades($habilidades){
        $this->habilidades = $habilidades;
        return $this;
    }

    public function cardFormatado()
    {

        $textoRegimeContracao = RegimeContratacaoEnum::from($this->getRegimeContratacao())->label();
        $textoRegimeTrabalho = RegimeTrabalhoEnum::from($this->getRegimeTrabalho())->label();
        $textoNivelSenioridade = NivelSenioridadeEnum::from($this->getNivelSenioridade())->label();
        $textoNivelHierarquico = NivelHierarquicoEnum::from($this->getNivelHierarquico())->label();

        return <<<HTML
                <div class='d-flex justify-content-between h-100 flex-column'>   
                    <div>
                        <div class='titulo ps-2 pe-2 align-items-center d-flex justify-content-between'>
                            <strong><a type='button' data-bs-toggle='modal' data-bs-target='#modal{$this->getId()}'>{$this->getTitulo()}</a></strong><i class='fas fa-thumbtack'></i>
                        </div>
                        <div class='p-2'>  
                            <p><i class='fas fa-building text-muted'></i> <small>{$this->getEmpresa()->getNome()}</small></p>
                            <p><i class='fas fa-medal text-muted'></i> {$this->getHabilidades()}</p>
                            <p><i class='fas fa-coins text-muted'></i> R$ {$this->getSalario()}</p>
                            <p>Regime de Contratação: {$textoRegimeContracao}</p>
                            <p>Regime de Trabalho: {$textoRegimeTrabalho}</p>
                            <p>Senioridade: {$textoNivelSenioridade}</p>
                            <p>Hierarquia: {$textoNivelHierarquico}</p>
                        </div>
                    </div>
                    <div class='ver-mais ps-2 pe-2 text-end d-flex justify-content-end align-items-baseline'>
                        <a type='button' data-bs-toggle='modal' data-bs-target='#modal{$this->getId()}'>Ver mais <i class='far fa-arrow-alt-circle-right'></i></a>
                    </div>
                </div>
                
                <div class='modal fade' id='modal{$this->getId()}' tabindex='-1' aria-labelledby='modal{$this->getId()}Label' aria-hidden='true'>
                    <div class='modal-dialog modal-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='modal{$this->getId()}Label'>Vaga #{$this->getId()}</h1>
                            </div>
                            <div class='modal-body'>
                                <h1>{$this->getTitulo()}</h1>
                                <h5>{$this->getEmpresa()->getNome()}</h5>
                                <br>
                                <p>Salário: R$ {$this->getSalario()}</p>
                                <p>Benefícios: {$this->getBeneficios()}</p>
                                <p>Descrição: {$this->getDescricao()}</p>
                                <p>Habilidades: {$this->getHabilidades()}</p>
                                <p>Carga Horária: {$this->getCargaHoraria()}</p>
                                <p>Regime de Contratação: {$textoRegimeContracao}</p>
                                <p>Regime de Trabalho: {$textoRegimeTrabalho}</p>
                                <p>Senioridade: {$textoNivelSenioridade}</p>
                                <p>Hierarquia: {$textoNivelHierarquico}</p>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Fechar</button>
                                <a href='/vaga/exibir/?id={$this->getId()}' class='btn btn-secondary mt-auto'>Ver mais <i class='far fa-arrow-alt-circle-right' aria-hidden='true'></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                HTML;
    }
}