<?php


abstract class HabilidadeDTO implements DTOInterface
{
    use DbTrait;
    public static function preencher($dados)
    {
        $habilidade = new Habilidade($dados['habilidade']);
        $habilidade->setId($dados['id']);
        return $habilidade;
    }
    public static function salvar($habilidade)
    {
        $pdo = static::conectarDB();

        if (empty($habilidade->getHabilidade())) {
            $sql = "INSERT INTO habilidade (id, habilidade) 
        VALUES ({$habilidade->getId()}, \"{$habilidade->getHabilidade()}\")";
        } else {
            $sql = "UPDATE habilidade SET ";
            $sql .= "habilidade = \"{$habilidade->getHabilidade()}\" ";
            $sql .= " WHERE id = {$habilidade->getId()}";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    public static function deletar($habilidade)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM habilidade WHERE id = {$habilidade->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    public static function listar($habilidade_id = '', $vaga_id ='')
    {
        $pdo = static::conectarDB();

        $sql = "SELECT habilidade.* 
                FROM habilidade ";
        $sql .= !empty($vaga_id) ? "INNER JOIN vaga_habilidade ON habilidade.id = vaga_habilidade.habilidade_id " : '' ;
        $sql .= "WHERE 1 ";
        $sql .= !empty($habilidade_id) ? "AND habilidade.id = $habilidade_id " : '';
        $sql .= !empty($vaga_id) ? "AND vaga_habilidade.vaga_id = $vaga_id " : '';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($habilidade = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($habilidade);
        }
        return $retorno;
    }
    public static function recuperar($id)
    {
        $pdo = static::conectarDB();
        $sql = "SELECT * FROM habilidade WHERE id = $id ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($habilidade = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($habilidade);
        }

        return $retorno;
    }
}