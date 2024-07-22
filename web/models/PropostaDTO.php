<?php

abstract class PropostaDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $vaga = VagaDTO::recuperar($dados['id_vaga']);
        $candidato = CandidatoDTO::recuperar($dados['id_candidato']);
        $propostas = new Propostas($vaga, $candidato, $dados['salario'], $dados['regime_contratacao'], $dados['regime_trabalho'], $dados['nivel_hierarquico'], $dados['nivel_senioridade'], $dados['cargo'], $dados['endereco'], $dados['expediente'], $dados['data_inicio'], $dados['aceite']);

        return $propostas;
    }

    public static function salvar($propostas)
    {
        $pdo = static::conectarDB();

        /*
        *Não foi criado o enum de status de um candidato
        *Não é passado o valor de data_inicio ao inserir dados na tabela propostas
        */

        if(!static::verificaDadosExistentes($propostas)){
            $sql = "INSERT INTO propostas(id_vaga, id_candidato, salario, regime_contratacao, regime_trabalho, nivel_hierarquico, nivel_senioridade, cargo, endereco, expediente, aceite)
                    VALUES({$propostas->getVaga()->getId()}, {$propostas->getCandidato()->getId()}, {$propostas->getSalario()}, {$propostas->getRegimeContratacao()}, {$propostas->getRegimeTrabalho()}, {$propostas->getNivelHierarquico()}, {$propostas->getNivelSenioridade()}, \"{$propostas->getCargo()}\", \"{$propostas->getEndereco()}\", \"{$propostas->getExpediente()}\", {$propostas->getAceite()})";
        }else{
            $sql = "UPDATE propostas SET ";
            $sql .= "salario = '{$propostas->getSalario()}', ";
            $sql .= "regime_contratacao = '{$propostas->getRegimeContratacao()}', ";
            $sql .= "regime_trabalho = '{$propostas->getRegimeTrabalho()}', ";
            $sql .= "nivel_hierarquico = '{$propostas->getNivelHierarquico()}', ";
            $sql .= "nivel_senioridade = '{$propostas->getNivelSenioridade()}', ";
            $sql .= "cargo = '{$propostas->getCargo()}', ";
            $sql .= "endereco = '{$propostas->getEndereco()}', ";
            $sql .= "expediente = '{$propostas->getExpediente()}', ";
            $sql .= "data_inicio = '{$propostas->getDataInicio()}', ";
            $sql .= "aceite = '{$propostas->getAceite()}' ";
            $sql .= "WHERE id_vaga = '{$propostas->getVaga()->getId()}' AND id_candidato = '{$propostas->getCandidato()->getId()}' ";
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
        while($propostas = $stmt->fetch(PDO::FETCH_ASSOC)){
            $retorno[] = static::preencher($propostas);
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
        while ($propostas = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($propostas);
        }

        return $retorno;
    }

    public static function deletar($propostas)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM propostas WHERE id_vaga = {$propostas->getVaga()->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    
    public static function verificaDadosExistentes($propostas)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT COUNT(1) AS Total FROM propostas ";
        $sql .= "WHERE propostas.id_vaga LIKE '{$propostas->getVaga()->getId()}' AND propostas.id_candidato LIKE '{$propostas->getCandidato()->getId()}'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros['Total'] != 0;
    }

}