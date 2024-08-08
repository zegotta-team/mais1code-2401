<?php

abstract class CategoriaHabilidadeDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados) 
    {
        $categoria = new CategoriaHabilidade($dados['nome']);
        $categoria->setId($dados['id']);
        return $categoria;
    }

    public static function salvar($categoria) 
    {
        $pdo = static::conectarDB();

        if (static::verificar($categoria->getNome())) {
            $sql = "SELECT * FROM categoria_habilidade WHERE nome = '{$categoria->getNome()}' ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $categoriaExistente = $stmt->fetch(PDO::FETCH_ASSOC);

            $categoria->setId($categoriaExistente['id']);
        }

        if (empty($categoria->getId())) {
            $sql = "INSERT INTO categoria_habilidade (nome) VALUES (\"{$categoria->getNome()}\")";
        } else{
            $sql = "UPDATE categoria_habilidade SET ";
            $sql .= "nome = '{$categoria->getNome()}' ";
            $sql .= "WHERE id = '{$categoria->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($categoria->getId())) {
            $categoria->setId($pdo->lastInsertId());
        }
    }

    public static function deletar($categoria) 
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM categoria_habilidade WHERE id = {$categoria->getId()}";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($id) 
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM categoria_habilidade WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($categoria = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($categoria);
        }

        return $retorno;
    }

    public static function listar($categoria_id = '', $habilidade_id = '') 
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM categoria_habilidade ";
        $sql .= !empty($habilidade_id) ? "INNER JOIN habilidade ON categoria_habilidade.id = habilidade.categoria_id " : '';
        $sql .= "WHERE 1 ";
        $sql .= !empty($categoria_id) ? "AND categoria_habilidade.id = $categoria_id " : '';
        $sql .= !empty($habilidade_id) ? "AND habilidade.id = $habilidade_id " : '';
        $sql .= "ORDER BY categoria_habilidade.nome ASC ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while($categoria = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($categoria);
        }

        return $retorno;
    }

    public static function verificar($nome) 
    {
        $pdo = static::conectarDB();

        $sql = "SELECT COUNT(1) AS Total FROM categoria_habilidade WHERE categoria_habilidade.nome = '$nome'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros['Total'] != 0;
    }
}