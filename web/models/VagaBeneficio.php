<?php
class VagaBeneficio
{
   private Vaga $vaga;
   private Beneficio $beneficio;
   private $informacao;

   public function __construct($vaga, $beneficio, $informacao)
   {
        $this->setVaga($vaga);
        $this->setBeneficio($beneficio);
        $this->setInformacao($informacao);
   }

   public function getVaga()
   {
        return $this->vaga;
   }

   public function setVaga($vaga)
   {
        $this->vaga = $vaga;
        return $this;
   }

   public function getBeneficio()
   {
        return $this->beneficio;
   }

   public function setBeneficio($beneficio)
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