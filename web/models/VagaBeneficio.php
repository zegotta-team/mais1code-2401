<?php
class VagaBeneficio
{
   private Vaga $vaga;
   private Beneficio $beneficio;
   private $informacao;

   public function __construct($vaga, $beneficio, $informacao)
   {
        $this->setVagaId($vaga);
        $this->setBeneficioId($beneficio);
        $this->setInformacao($informacao);
   }

   public function getVagaId()
   {
        return $this->vaga;
   }

   public function setVagaId($vaga)
   {
        $this->vaga = $vaga;
        return $this;
   }

   public function getBeneficioId()
   {
        return $this->beneficio;
   }

   public function setBeneficioId($beneficio)
   {
        $this->beneficio = $beneficio;
        return $this;
   }

   public function getInformacao()
   {
        return $this->informacao;
   }

   public function setInformacao($informacao)
   {
        $this->informacao = $informacao;
        return $this;
   }
}