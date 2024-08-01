<?php
class VagaBeneficio
{
   private $vagaId;
   private $beneficioId;
   private $informacao;

   public function __construct($vagaId, $beneficioId, $informacao)
   {
        $this->setVagaId($vagaId);
        $this->setBeneficioId($beneficioId);
        $this->setInformacao($informacao);
   }

    public function toArray()
    {
        return [
            "vagaId" => $this->getVagaId(),
            "beneficioId" => $this->getBeneficioId(),
            "informacao" => $this->getInformacao()
        ];
    }

   public function getVagaId()
   {
        return $this->vagaId;
   }

   public function setVagaId($vagaId)
   {
        $this->vagaId = $vagaId;
        return $this;
   }

   public function getBeneficioId()
   {
        return $this->beneficioId;
   }

   public function setBeneficioId($beneficioId)
   {
        $this->beneficioId = $beneficioId;
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