<?php

class Vaga
{
    private $id;
    private Filial $filial;
    private Empresa $empresa;
    private $titulo;
    private $email;
    private $salario;
    private $descricao;
    private $cargaHoraria;
    private $regimeContratacao;
    private $regimeTrabalho;
    private $nivelSenioridade;
    private $nivelHierarquico;
    private $status;
    private $habilidades;
    private $beneficios;

    public function __construct($filial, $empresa, $titulo, $email, $salario, $descricao, $cargaHoraria, $regimeContratacao, $regimeTrabalho, $nivelSenioridade, $nivelHierarquico, $status, $habilidades, $beneficios)
    {
        $this->setFilial($filial);
        $this->setEmpresa($empresa);
        $this->setTitulo($titulo);
        $this->setEmail($email);
        $this->setSalario($salario);
        $this->setDescricao($descricao);
        $this->setCargaHoraria($cargaHoraria);
        $this->setRegimeContratacao($regimeContratacao);
        $this->setRegimeTrabalho($regimeTrabalho);
        $this->setNivelSenioridade($nivelSenioridade);
        $this->setNivelHierarquico($nivelHierarquico);
        $this->setStatus($status);
        $this->setHabilidades($habilidades);
        $this->setBeneficios($beneficios);
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'filial' => $this->getFilial()->toArray(),
            'empresa' => $this->getEmpresa()->toArray(),
            'titulo' => $this->getTitulo(),
            'email' => $this->getEmail(),
            'salario' => $this->getSalario(),
            'descricao' => $this->getDescricao(),
            'cargaHoraria' => $this->getCargaHoraria(),
            'regimeContratacao' => $this->getRegimeContratacao(),
            'regimeTrabalho' => $this->getRegimeTrabalho(),
            'nivelSenioridade' => $this->getNivelSenioridade(),
            'nivelHierarquico' => $this->getNivelHierarquico(),
            'status' => $this->getStatus(),
            'habilidades' =>  array_map(function($item) { return $item->toArray(); },$this->getHabilidades()),
            'beneficios' => array_map(function($item) { return $item->toArray(); }, $this->getBeneficios())
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

    /**
     * @return mixed
     */
    public function getBeneficios()
    {
        return $this->beneficios;
    }

    /**
     * @param mixed $beneficios
     * @return Vaga
     */
    public function setBeneficios($beneficios)
    {
        $this->beneficios = $beneficios;
        return $this;
    }

    public function temHabilidadeId($id)
    {
        foreach ($this->habilidades as $habilidade) {
            if ($id === $habilidade->getId()) {
                return true;
            }
        }

        return false;
    }

    public function temBeneficioId($id)
    {
        foreach ($this->beneficios as $beneficio) {
            if ($id === $beneficio->getBeneficioId()) {
                return $beneficio;
            }
        }

        return false;
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

        $beneficios = '';
        foreach ($this->getBeneficios() as $vagaBeneficio) {
            $beneficio = BeneficioDTO::recuperar($vagaBeneficio->getBeneficioId());
            $beneficios .= "<span class='badge badge-outline badge-sm sm:badge-md'>{$beneficio->getNome()}</span>";
        }

        $replaces = [
            '{id}' => $this->getId(),
            '{vaga}' => $this->getTitulo(),
            '{empresa}' => $this->getEmpresa()->getNome(),
            '{empresaId}' => $this->getEmpresa()->getId(),
            '{logo}' => $this->getEmpresa()->getLogo(),
            '{habilidades}' => $habilidades,
            '{beneficios}' => $beneficios,
            '{regimeContratacao}' => $textoRegimeContracao,
            '{regimeTrabalho}' => $textoRegimeTrabalho,
            '{salario}' => $this->getSalario(),
            '{niveis}' => $textoNivelHierarquico . ' ' . $textoNivelSenioridade,
            '{localidade}' => $this->getFilial()->getCidade() . ', ' . $this->getFilial()->getEstado(),
            '{descricao}' => $this->getDescricao(),
            '{cargaHoraria}' => $this->getCargaHoraria(),
            '{percentual}' => $percentual,
            '{selo}' => !is_null(Session::get(TipoUsuarioEnum::CANDIDATO->session_key())) && Session::get(TipoUsuarioEnum::CANDIDATO->session_key())->estaCandidatado($this->getId()) ?
                '<div class="flex gap-2 items-center text-success font-bold text-xs flex-wrap"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" /></svg> Você está na disputa!</div>
' : '&nbsp;',
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
