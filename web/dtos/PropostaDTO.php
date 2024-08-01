<?php

abstract class PropostaDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $vaga = VagaDTO::recuperar($dados['id_vaga']);
        $candidato = CandidatoDTO::recuperar($dados['id_candidato']);
        $proposta = new Proposta($vaga, $candidato, $dados['salario'], $dados['regime_contratacao'], $dados['regime_trabalho'], $dados['nivel_hierarquico'], $dados['nivel_senioridade'], $dados['cargo'], $dados['endereco'], $dados['expediente'], $dados['data_inicio'], $dados['aceite']);

        return $proposta;
    }

    public static function salvar($proposta)
    {
        $pdo = static::conectarDB();

        /*
        *Não foi criado o enum de status de um candidato
        *Não é passado o valor de data_inicio ao inserir dados na tabela propostas
        */

        if(!static::verificaDadosExistentes($proposta)){
            $sql = "INSERT INTO propostas(id_vaga, id_candidato, salario, regime_contratacao, regime_trabalho, nivel_hierarquico, nivel_senioridade, cargo, endereco, expediente, data_inicio, aceite)
                    VALUES({$proposta->getVaga()->getId()}, {$proposta->getCandidato()->getId()}, {$proposta->getSalario()}, {$proposta->getRegimeContratacao()}, {$proposta->getRegimeTrabalho()}, {$proposta->getNivelHierarquico()}, {$proposta->getNivelSenioridade()}, \"{$proposta->getCargo()}\", \"{$proposta->getEndereco()}\", \"{$proposta->getExpediente()}\", \"{$proposta->getDataInicio()}\" , {$proposta->getAceite()})";
        }else{
            $sql = "UPDATE propostas SET ";
            $sql .= "salario = '{$proposta->getSalario()}', ";
            $sql .= "regime_contratacao = '{$proposta->getRegimeContratacao()}', ";
            $sql .= "regime_trabalho = '{$proposta->getRegimeTrabalho()}', ";
            $sql .= "nivel_hierarquico = '{$proposta->getNivelHierarquico()}', ";
            $sql .= "nivel_senioridade = '{$proposta->getNivelSenioridade()}', ";
            $sql .= "cargo = '{$proposta->getCargo()}', ";
            $sql .= "endereco = '{$proposta->getEndereco()}', ";
            $sql .= "expediente = '{$proposta->getExpediente()}', ";
            $sql .= "data_inicio = '{$proposta->getDataInicio()}', ";
            $sql .= "aceite = '{$proposta->getAceite()}' ";
            $sql .= "WHERE id_vaga = '{$proposta->getVaga()->getId()}' AND id_candidato = '{$proposta->getCandidato()->getId()}' ";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function listar($id_vaga = '', $id_candidato = '')
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM propostas WHERE 1 ";
        $sql .= !empty($id_vaga) ? "AND propostas.id_vaga = $id_vaga " : '';
        $sql .= !empty($id_candidato) ? "AND propostas.id_candidato = $id_candidato " : '';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while($proposta = $stmt->fetch(PDO::FETCH_ASSOC)){
            $retorno[] = static::preencher($proposta);
        }
        return $retorno;
    }

    public static function recuperar($id_vaga, $id_candidato = '')
    {

        $pdo = static::conectarDB();
        $sql = "SELECT * FROM propostas WHERE id_vaga = $id_vaga AND id_candidato = $id_candidato";


        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($proposta = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($proposta);
        }

        return $retorno;
    }

    public static function deletar($proposta)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM propostas WHERE id_vaga = {$proposta->getVaga()->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function verificaDadosExistentes($proposta)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT COUNT(1) AS Total FROM propostas ";
        $sql .= "WHERE propostas.id_vaga LIKE '{$proposta->getVaga()->getId()}' AND propostas.id_candidato LIKE '{$proposta->getCandidato()->getId()}'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros['Total'] != 0;
    }

}