<?php
class PainelVagasController
{
   public function __construct()
   {
    
   }
   public static function painelDeVagas()
    {
        $vagas = VagaDTO::listar('','');
        View::renderizar('vaga/index', compact('vagas'));
    }
}