<?php

abstract class NotificacoesDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados) 
    {
        $candidato = CandidatoDTO::recuperar($dados['candidato_id']);
        $empresa = EmpresaDTO::recuperar($dados['empresa_id']);
        $notificacoes = new Notificacoes($candidato, $empresa, $dados['titulo'], $dados['descricao'], $dados['status'], $dados['data_hora']);
        $notificacoes->setId($dados['id']);

        return $notificacoes;
    }

    public static function salvar($notificacoes) 
    {
        $pdo = static::conectarDB();

        if ($notificacoes->getStatus() == NotificacoesStatusEnum::NaoLida->value && empty($notificacoes->getId())) {
            $sql = "INSERT INTO notificacoes (candidato_id, empresa_id, titulo, descricao, `status`, data_hora)
                    VALUES ({$notificacoes->getCandidato()->getId()}, {$notificacoes->getEmpresa()->getId()}, \"{$notificacoes->getTitulo()}\", \"{$notificacoes->getDescricao()}\", \"{$notificacoes->getStatus()}\", \"{$notificacoes->getDataHora()}\")";
        } else{
            $sql = "UPDATE notificacoes SET ";
            $sql .= "titulo = '{$notificacoes->getTitulo()}', ";
            $sql .= "descricao = '{$notificacoes->getDescricao()}', ";
            $sql .= "`status` = '{$notificacoes->getStatus()}', ";
            $sql .= "data_hora = '{$notificacoes->getDataHora()}' ";
            $sql .= "WHERE id = '{$notificacoes->getId()}'";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($notificacoes->getId())) {
            $notificacoes->setId($pdo->lastInsertId());
        }
    }

    public static function deletar($notificacoes) 
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM notificacoes WHERE id = {$notificacoes->getId()}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function listar($candidato_id = '', $empresa_id = '', $status = '') 
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM notificacoes n WHERE 1 ";
        $sql .= !empty($candidato_id) ? "AND n.candidato_id = $candidato_id " : '';
        $sql .= !empty($empresa_id) ? "AND n.empresa_id = $empresa_id " : '';
        $sql .= !empty($status) ? "AND n.status = $status " : '';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while($notificacoes = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($notificacoes);
        }

        return $retorno;
    }

    public static function recuperar($id) 
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM notificacoes WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while($notificacoes = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($notificacoes);
        }

        return $retorno;
    }
}