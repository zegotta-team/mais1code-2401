<?php

abstract class VagaDTO implements DTOInterface
{
    use DbTrait;

    public static function salvar($vaga)
    {
        $pdo = static::conectarDB();
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

        if (empty($vaga->getId())) {
            $vaga->setId($pdo->lastInsertId());
        }
    }

    public static function deletar($vaga)
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

    public static function recuperar($id)
    {
        $pdo = static::conectarDB();
        $sql = "SELECT * FROM vaga WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($vaga = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = EmpresaDTO::recuperar($vaga['empresa_id']);
            $objVaga = new Vaga($objEmpresa, $vaga['titulo'], $vaga['email'], $vaga['salario'], $vaga['beneficios'], $vaga['descricao'], $vaga['requisitos'], $vaga['cargaHoraria']);
            $objVaga->setId($vaga['id']);
            $retorno = $objVaga;
        }

        return $retorno;
    }

    public static function listar($empresaId = '', $filtro = '')
    {
        $pdo = static::conectarDB();
        $sql = "SELECT e.nome, v. *
                FROM vaga v 
                INNER JOIN empresa e ON e.id = v.empresa_id AND e.id = $empresaId
                WHERE v.titulo LIKE :curinga OR v.email LIKE :curinga OR e.email LIKE :curinga OR e.nome LIKE :curinga";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':curinga', "%{$filtro}%");
        $stmt->execute();

        $retorno = [];
        while ($vaga = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = EmpresaDTO::recuperar($vaga['empresa_id']);
            $objVaga = new Vaga($objEmpresa, $vaga['titulo'], $vaga['email'], $vaga['salario'], $vaga['beneficios'], $vaga['descricao'], $vaga['requisitos'], $vaga['cargaHoraria']);
            $objVaga->setId($vaga['id']);
            $retorno[] = $objVaga;
        }
        return $retorno;
    }

}