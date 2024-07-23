<?php

class Vaga
{
    private $id;
    private Filial $filial;
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


    public function __construct($filial, $empresa, $titulo, $email, $salario, $beneficios, $descricao, $cargaHoraria, $regimeContratacao, $regimeTrabalho, $nivelSenioridade, $nivelHierarquico, $status, $habilidades)
    {
        $this->setFilial($filial);
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

    public function getFilial()
    {
        return $this->filial;
    }

    public function setFilial($filial)
    {
        $this->filial = $filial;
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

    public function getHabilidades()
    {
        return $this->habilidades;
    }

    public function setHabilidades($habilidades)
    {
        $this->habilidades = $habilidades;
        return $this;
    }

    public function cardFormatado($percentual = null)
    {

        $textoRegimeContracao = RegimeContratacaoEnum::from($this->getRegimeContratacao())->label();
        $textoRegimeTrabalho = RegimeTrabalhoEnum::from($this->getRegimeTrabalho())->label();
        $textoNivelSenioridade = NivelSenioridadeEnum::from($this->getNivelSenioridade())->label();
        $textoNivelHierarquico = NivelHierarquicoEnum::from($this->getNivelHierarquico())->label();

        $habilidades = '';
        foreach ($this->getHabilidades() as $habilidade) {
            $habilidades .= "<span class='badge badge-outline badge-sm sm:badge-md'>{$habilidade->getHabilidade()}</span>";
        }

        if (!empty($percentual) || $percentual === 0) {
            $percentual = "<span class='indicator-item indicator-start left-5 badge badge-success text-white rounded-full h-10 w-10 p-4'>{$percentual}%</span>";
        }

        $replaces = [
            '{id}' => $this->getId(),
            '{vaga}' => $this->getTitulo(),
            '{empresa}' => $this->getEmpresa()->getNome(),
            '{logo}' => $this->getEmpresa()->getLogo(),
            '{habilidades}' => $habilidades,
            '{regimeContratacao}' => $textoRegimeContracao,
            '{regimeTrabalho}' => $textoRegimeTrabalho,
            '{salario}' => $this->getSalario(),
            '{niveis}' => $textoNivelHierarquico . ' ' . $textoNivelSenioridade,
            '{localidade}' => $this->getFilial()->getCidade() . ', ' . $this->getFilial()->getEstado(),
            '{beneficios}' => $this->getBeneficios(),
            '{descricao}' => $this->getDescricao(),
            '{cargaHoraria}' => $this->getCargaHoraria(),
            '{percentual}' => $percentual
        ];
        $card = file_get_contents(__DIR__ . '/../../web/views/vaga/card.html');
        $card = str_replace(array_keys($replaces), array_values($replaces), $card);
        return $card;
    }

    public function temCandidatos()
    {
        $lista = CandidatoVagaDTO::listar('', $this->id);

        return !empty($lista);
    }
}
