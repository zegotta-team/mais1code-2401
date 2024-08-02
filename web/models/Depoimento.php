<?php

class Depoimento
{
    private $id;
    private $empresaId;
    private $candidatoId;
    private $depoimento;
    private $avaliacao;

    public function __construct($empresaId, $candidatoId, $depoimento, $avaliacao)
    {
        $this->setEmpresaId($empresaId);
        $this->setCandidatoId($candidatoId);
        $this->setDepoimento($depoimento);
        $this->setAvaliacao($avaliacao);
    }

    public function toArray()
    {
        return [
//            'id' => $this->getId(),
//            'nome' => $this->getNome(),
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Depoimento
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmpresaId()
    {
        return $this->empresaId;
    }

    /**
     * @param mixed $empresaId
     * @return Depoimento
     */
    public function setEmpresaId($empresaId)
    {
        $this->empresaId = $empresaId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCandidatoId()
    {
        return $this->candidatoId;
    }

    /**
     * @param mixed $candidatoId
     * @return Depoimento
     */
    public function setCandidatoId($candidatoId)
    {
        $this->candidatoId = $candidatoId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepoimento()
    {
        return $this->depoimento;
    }

    /**
     * @param mixed $depoimento
     * @return Depoimento
     */
    public function setDepoimento($depoimento)
    {
        $this->depoimento = $depoimento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAvaliacao()
    {
        return $this->avaliacao;
    }

    /**
     * @param mixed $avaliacao
     * @return Depoimento
     */
    public function setAvaliacao($avaliacao)
    {
        $this->avaliacao = $avaliacao;
        return $this;
    }




}


