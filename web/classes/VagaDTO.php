<?php

abstract class VagaDTO
{
    const BANCO = '../db.sqlite';

    public static function salvar($vaga)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (empty($vaga->getId())) {
            $sql = "INSERT INTO vaga (empresa_id, titulo, email, salario, beneficios, descricao, requisitos, cargaHoraria) 
            VALUES ({$vaga->getEmpresa()->getId()}, \"{$vaga->getTitulo()}\", \"{$vaga->getEmail()}\", {$vaga->getSalario()}, \"{$vaga->getBeneficios()}\", \"{$vaga->getDescricao()}\", \"{$vaga->getRequisitos()}\", {$vaga->getCargaHoraria()})";
        } else {
            $sql = "UPDATE vaga SET ";
            $sql .= "titulo = '{$vaga->getTitulo()}', ";
            $sql .= "email = '{$vaga->getEmail()}', ";
            $sql .= "salario = '{$vaga->getSalario()}', ";
            $sql .= "beneficios = '{$vaga->getBeneficios()}', ";
            $sql .= "descricao = '{$vaga->getDescricao()}', ";
            $sql .= "requisitos = '{$vaga->getRequisitos()}', ";
            $sql .= "cargaHoraria = '{$vaga->getCargaHoraria()}' ";
            $sql .= "WHERE id = {$vaga->getId()}";
        }
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $vaga->setId($pdo->lastInsertId());
    }

    public static function selecionaDados($empresaId, $filtro)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT e.nome, v. *
                FROM vaga v 
                INNER JOIN empresa e ON e.id = v.empresa_id AND e.id = $empresaId
                WHERE v.titulo LIKE :curinga OR v.email LIKE :curinga OR e.email LIKE :curinga OR e.nome LIKE :curinga";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':curinga', "%{$filtro}%");
        $stmt->execute();

        $retorno = [];
        while ($vaga = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = EmpresaDTO::getById($vaga['empresa_id']);
            $objVaga = new Vaga($objEmpresa, $vaga['titulo'], $vaga['email'], $vaga['salario'], $vaga['beneficios'], $vaga['descricao'], $vaga['requisitos'], $vaga['cargaHoraria']);
            $objVaga->setId($vaga['id']);
            $retorno[] = $objVaga;
        }
        return $retorno;
    }

    public static function alteraDados($alteracao, $novoDado, $id)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE vaga SET $alteracao = \"$novoDado\" WHERE id = $id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function consultarVagas($empresaId, $buscar)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Conexão com banco de dados ok! status(200)\n";

        $sqlListName = "SELECT v.id, v.titulo, e.nome 
                        FROM vaga v 
                        INNER JOIN empresa e ON e.id = v.empresa_id AND e.id = $empresaId
                        WHERE v.titulo LIKE :curinga OR v.email LIKE :curinga OR e.email LIKE :curinga OR e.nome LIKE :curinga";

        $stmt = $pdo->prepare($sqlListName);
        // bindParam parecido com replace
        $stmt->bindValue(':curinga', "%{$buscar}%"); // usar bindValue ao invés de bindParam
        $stmt->execute();
        // configura os dados consultados como uma matriz
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // Método  estático que deverá receber o id da vaga a ser removida, fazer a conexão com o banco de dados e executar o DELETE
    public static function removerVagaDB($vaga)
    {
        try {
            $diretorio_raiz = dirname(__DIR__);
            $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

            $pdo = new PDO("sqlite:$caminho_banco");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM vaga WHERE id = {$vaga->getId()}";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public static function getById($id)
    {
        $diretorio_raiz = dirname(__DIR__);
        $caminho_banco = realpath($diretorio_raiz . '/' . self::BANCO);

        $pdo = new PDO("sqlite:$caminho_banco");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM vaga WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($vaga = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = EmpresaDTO::getById($vaga['empresa_id']);
            $objVaga = new Vaga($objEmpresa, $vaga['titulo'], $vaga['email'], $vaga['salario'], $vaga['beneficios'], $vaga['descricao'], $vaga['requisitos'], $vaga['cargaHoraria']);
            $objVaga->setId($vaga['id']);
            $retorno = $objVaga;
        }

        return $retorno;
    }

}