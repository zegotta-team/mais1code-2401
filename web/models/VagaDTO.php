<?php

abstract class VagaDTO implements DTOInterface
{
    use DbTrait;

    public static function salvar($vaga)
    {
        $pdo = static::conectarDB();
        if (empty($vaga->getId())) {
            $sql = "INSERT INTO vaga (empresa_id, titulo, email, salario, beneficios, descricao, requisitos, cargaHoraria, status) 
            VALUES ({$vaga->getEmpresa()->getId()}, \"{$vaga->getTitulo()}\", \"{$vaga->getEmail()}\", {$vaga->getSalario()}, \"{$vaga->getBeneficios()}\", \"{$vaga->getDescricao()}\", \"{$vaga->getRequisitos()}\", \"{$vaga->getCargaHoraria()}\", {$vaga->getStatus()})";
        } else {
            $sql = "UPDATE vaga SET ";
            $sql .= "titulo = '{$vaga->getTitulo()}', ";
            $sql .= "email = '{$vaga->getEmail()}', ";
            $sql .= "salario = '{$vaga->getSalario()}', ";
            $sql .= "beneficios = '{$vaga->getBeneficios()}', ";
            $sql .= "descricao = '{$vaga->getDescricao()}', ";
            $sql .= "requisitos = '{$vaga->getRequisitos()}', ";
            $sql .= "cargaHoraria = '{$vaga->getCargaHoraria()}', ";
            $sql .= "status = '{$vaga->getStatus()}' ";
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
            $pdo = static::conectarDB();
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
            $objVaga = new Vaga($objEmpresa, $vaga['titulo'], $vaga['email'], $vaga['salario'], $vaga['beneficios'], $vaga['descricao'], $vaga['requisitos'], $vaga['cargaHoraria'], $vaga['status']);
            $objVaga->setId($vaga['id']);
            $retorno = $objVaga;
        }

        return $retorno;
    }

  
    public static function listar($empresaId = '', $filtro = '', $status = '')
    {

        $pdo = static::conectarDB();
        $sql = "SELECT e.nome, v. * FROM vaga v ";
        $sql .= "INNER JOIN empresa e ON e.id = v.empresa_id ";
        $sql .= "WHERE (v.titulo LIKE :curinga OR v.email LIKE :curinga OR e.email LIKE :curinga OR e.nome LIKE :curinga) ";
        $sql .= !empty($empresaId) ? "AND e.id = '$empresaId' " : "";
        $sql .= !empty($status) || $status == '0' ? "AND v.status = '$status' " : "";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':curinga', "%{$filtro}%");
        $stmt->execute();

        $retorno = [];
        while ($vaga = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objEmpresa = EmpresaDTO::recuperar($vaga['empresa_id']);
            $objVaga = new Vaga($objEmpresa, $vaga['titulo'], $vaga['email'], $vaga['salario'], $vaga['beneficios'], $vaga['descricao'], $vaga['requisitos'], $vaga['cargaHoraria'], $vaga['status']);
            $objVaga->setId($vaga['id']);
            $retorno[] = $objVaga;
        }
        return $retorno;
    }

}


