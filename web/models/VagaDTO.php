<?php

abstract class VagaDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {

        $empresa = EmpresaDTO::recuperar($dados['empresa_id']);
        $filial = FilialDTO::recuperar($dados['filial_id']);
        $habilidades = HabilidadeDTO::listar('', $dados['id']);


        $vaga = new Vaga($filial, $empresa, $dados['titulo'], $dados['email'], $dados['salario'], $dados['beneficios'], $dados['descricao'], $dados['cargaHoraria'], $dados['regimeContratacao'], $dados['regimeTrabalho'], $dados['nivelSenioridade'], $dados['nivelHierarquia'], $dados['status'], $habilidades);
        $vaga->setId($dados['id']);

        return $vaga;
    }

    public static function salvar($vaga)
    {

        $pdo = static::conectarDB();
        if (empty($vaga->getId())) {
            $sql = "INSERT INTO vaga (filial_id, empresa_id, titulo, email, salario, beneficios, descricao, cargaHoraria, regimeContratacao, regimeTrabalho, nivelSenioridade, nivelHierarquia, status) 
                    VALUES ({$vaga->getFilial()->getId()}, {$vaga->getEmpresa()->getId()}, \"{$vaga->getTitulo()}\", \"{$vaga->getEmail()}\", {$vaga->getSalario()}, \"{$vaga->getBeneficios()}\", \"{$vaga->getDescricao()}\", \"{$vaga->getCargaHoraria()}\", \"{$vaga->getRegimeContratacao()}\", \"{$vaga->getRegimeTrabalho()}\", \"{$vaga->getNivelSenioridade()}\", \"{$vaga->getNivelHierarquico()}\", \"{$vaga->getStatus()}\")";
        } else {
            $sql = "UPDATE vaga SET ";
            $sql .= "filial_id = '{$vaga->getFilial()->getId()}', ";
            $sql .= "titulo = '{$vaga->getTitulo()}', ";
            $sql .= "email = '{$vaga->getEmail()}', ";
            $sql .= "salario = '{$vaga->getSalario()}', ";
            $sql .= "beneficios = '{$vaga->getBeneficios()}', ";
            $sql .= "descricao = '{$vaga->getDescricao()}', ";
            $sql .= "cargaHoraria = '{$vaga->getCargaHoraria()}', ";
            $sql .= "regimeContratacao = '{$vaga->getRegimeContratacao()}', ";
            $sql .= "regimeTrabalho = '{$vaga->getRegimeTrabalho()}', ";
            $sql .= "nivelSenioridade = '{$vaga->getNivelSenioridade()}', ";
            $sql .= "nivelHierarquia = '{$vaga->getNivelHierarquico()}', ";
            $sql .= "status = '{$vaga->getStatus()}' ";
            $sql .= "WHERE id = {$vaga->getId()}";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($vaga->getId())) {
            $vaga->setId($pdo->lastInsertId());
        }
        $sql = "DELETE FROM vaga_habilidade WHERE vaga_id = {$vaga->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        if (!empty($vaga->getHabilidades())) {

            foreach ($vaga->getHabilidades() as $habilidade) {

                $sql = "INSERT INTO vaga_habilidade(vaga_id, habilidade_id) 
                        VALUES(\"{$vaga->getId()}\",\"{$habilidade->getId()}\" )";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
            }
        }
    }

    public static function deletar($vaga)
    {
        try {
            $pdo = static::conectarDB();
            $sql = "DELETE FROM vaga WHERE id = {$vaga->getId()}";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $sql = "DELETE FROM vaga_habilidade WHERE vaga_id = {$vaga->getId()}";

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
            $retorno = static::preencher($vaga);
        }

        return $retorno;
    }

    public static function listar($empresaId = '', $filtro = '', $status = '', $filialId = '', $ordenacao = '', $filtro_hierarquia = '', $filtro_senioridade = '', $filtro_contratacao = '', $filtro_trabalho = '', $filtro_estado = '', $filtro_habilidade = '', $filtro_salarioDe = null, $filtro_salarioAte = null)
    {

        $pdo = static::conectarDB();

        $sql = "SELECT e.nome, v. * FROM vaga v ";
        $sql .= "INNER JOIN empresa e ON e.id = v.empresa_id ";
        $sql .= "INNER JOIN filial f ON f.id = v.filial_id ";
        $sql .= "LEFT JOIN vaga_habilidade vh ON vh.vaga_id = v.id ";
        $sql .= "WHERE 1 ";
        $sql .= !empty($filtro) ? "AND (v.titulo LIKE '%{$filtro}%' OR v.email LIKE '%{$filtro}%' OR e.email LIKE '%{$filtro}%' OR e.nome LIKE '%{$filtro}%') " : "";
        $sql .= !empty($empresaId) ? "AND e.id IN ($empresaId) " : "";
        $sql .= !empty($status) || $status == '0' ? "AND v.status = '$status' " : "";
        $sql .= !empty($filialId) ? "AND v.filial_id = '$filialId' " : "";
        $sql .= !empty($filtro_hierarquia) ? "AND v.nivelHierarquia IN ($filtro_hierarquia) " : "";
        $sql .= !empty($filtro_senioridade) ? "AND v.nivelSenioridade IN ($filtro_senioridade) " : "";
        $sql .= !empty($filtro_contratacao) ? "AND v.regimeContratacao IN ($filtro_contratacao) " : "";
        $sql .= !empty($filtro_trabalho) ? "AND v.regimeTrabalho IN ($filtro_trabalho) " : "";
        $sql .= !empty($filtro_estado) ? "AND f.estado IN ($filtro_estado) " : "";
        $sql .= !empty($filtro_habilidade) ? "AND vh.habilidade_id IN ($filtro_habilidade) " : "";
        $sql .= isset($filtro_salarioDe)  ? "AND v.salario >= $filtro_salarioDe " : "";
        $sql .= isset($filtro_salarioAte)  ? "AND v.salario <= $filtro_salarioAte " : "";
        $sql .= "GROUP BY v.id ";
        $sql .= !empty($ordenacao) ? "ORDER BY {$ordenacao->value}" : '';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($vaga = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($vaga);
        }
        return $retorno;
    }

}


