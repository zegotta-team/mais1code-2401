<?php
class VagaBeneficio
{
   private $vaga_id;
   private $beneficio_id;
   private $informacao;

   public function __construct($vaga_id, $beneficio_id, $informacao)
   {
        $this->setVagaId($vaga_id);
        $this->setBeneficioId($beneficio_id);
        $this->setInformacao($informacao);
   }

   public function getVagaId()
   {
        return $this->vaga_id;
   }

   public function setVagaId($vaga_id)
   {
        $this->vaga_id = $vaga_id;
        return $this;
   }

   public function getBeneficioId()
   {
        return $this->beneficio_id;
   }

   public function setBeneficioId($beneficio_id)
   {
        $this->beneficio_id = $beneficio_id;
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