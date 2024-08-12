<?php

/**
 * @noinspection PhpUnused
 */

class InstitucionalController
{
    public function sobre()
    {
        $layout = 'sistema-externo';
        if (Session::estaLogado([TipoUsuarioEnum::CANDIDATO])) {
            $layout = 'sistema-candidato';
        } elseif (Session::estaLogado([TipoUsuarioEnum::EMPRESA])) {
            $layout = 'sistema-usuario';
        }

        $easterEggs = $_GET['revelarSegredos'] ?? false;

        $time = [
            [
                'nome' => 'Alana Silva',
                'nomeCompleto' => 'Alana Clara da Silva Pereira',
                'foto' => 'alana.jpeg',
                'local' => 'Juazeiro do Norte, CE',
                'apelido' => 'A super paciente',
                'github' => 'Lana230',
                'linkedin' => 'alana-silva-ab94822a3',
                'whatsapp' => '5588999132393'
            ],
            [
                'nome' => 'Douglas Oliveira',
                'nomeCompleto' => 'Douglas Bitencourt de Oliveira',
                'foto' => 'douglas.jpeg',
                'local' => 'Porto Alegre, RS',
                'apelido' => 'O inimigo do Jira',
                'github' => 'DouglasB2022',
                'linkedin' => 'douglasbitencourt',
                'whatsapp' => '5551997781791'
            ],
            [
                'nome' => 'Edyelgue Carneiro',
                'nomeCompleto' => 'Edyelgue Antonio dos Santos Carneiro',
                'foto' => 'edy.jpeg',
                'local' => 'Sumaré, SP',
                'apelido' => 'O tosse sem fim',
                'github' => 'Edyelgue',
                'linkedin' => 'edyelgue-carneiro-a44215184',
                'whatsapp' => '5534991982482'
            ],
            [
                'nome' => 'Kauan Nascimento',
                'nomeCompleto' => 'Kauan da Silva Nascimento',
                'foto' => 'kauan.jpeg',
                'local' => 'Salvador, BA',
                'apelido' => 'O destruidor de Git',
                'github' => 'KauanNasciment0',
                'linkedin' => 'kauan-nascimento-567026315',
                'whatsapp' => '5571981041740'
            ]
        ];

        shuffle($time);

        View::renderizar('institucional/sobre', compact('time', 'easterEggs'), $layout);
    }

}