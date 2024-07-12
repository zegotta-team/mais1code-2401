<?php


abstract class HabilidadeDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $categoria = CategoriaHabilidadeDTO::recuperar($dados['categoria_id']);
        $habilidade = new Habilidade($dados['habilidade'], $categoria);
        $habilidade->setId($dados['id']);
        return $habilidade;
    }

    public static function salvar($habilidade)
    {
        $pdo = static::conectarDB();

        if (empty($habilidade->getId())) {
            if (!static::verificaDadosExistentes($habilidade->getHabilidade())) {
                $sql = "INSERT INTO habilidade (habilidade, categoria_id) 
                        VALUES (\"{$habilidade->getHabilidade()}\", \"{$habilidade->getCategoria()->getId()}\")";
            } else{
                die();
            }
        } else {
            $sql = "UPDATE habilidade SET ";
            $sql .= "habilidade = '{$habilidade->getHabilidade()}', ";
            $sql .= "categoria_id = '{$habilidade->getCategoria()->getId()}' ";
            $sql .= "WHERE id = {$habilidade->getId()}";
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

    public static function listar($habilidade_id = '', $vaga_id = '', $categoria_id = '')
    {
        $pdo = static::conectarDB();

        $sql = "SELECT h.*
                FROM habilidade h ";
        $sql .= !empty($vaga_id) ? "INNER JOIN vaga_habilidade vh ON h.id = vh.habilidade_id " : "";
        $sql .= "WHERE 1 ";
        $sql .= !empty($habilidade_id) ? "AND h.id = $habilidade_id " : '';
        $sql .= !empty($vaga_id) ? "AND vh.vaga_id = $vaga_id " : '';
        $sql .= !empty($categoria_id) ? "AND h.categoria_id = $categoria_id " : '';
        $sql .= "ORDER BY h.habilidade ASC ";

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

    public static function verificaDadosExistentes($habilidade)
    {
        $pdo = static::conectarDB();

        if(empty($habilidade)){
            return true;
        }
        $sql = "SELECT COUNT(1) AS Total FROM habilidade ";
        $sql .= "WHERE habilidade.habilidade LIKE '$habilidade' ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros['Total'] != 0;
    }
}