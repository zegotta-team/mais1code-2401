<?php

abstract class CandidatoDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $pdo = static::conectarDB();
        $sql = "SELECT habilidade_id FROM candidato_habilidade WHERE candidato_id = {$dados['id']} ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $habilidades = [];
        while ($habilidade = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $habilidades[] = HabilidadeDTO::recuperar($habilidade['habilidade_id']);
        }

        $sql = "SELECT beneficio_id FROM candidato_beneficio WHERE candidato_id = {$dados['id']}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $beneficios = [];
        while ($beneficio = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $beneficios[] = BeneficioDTO::recuperar($beneficio['beneficio_id']);
        }

        $candidato = new Candidato($dados['nome'], $dados['email'], $dados['senha'], $dados['cpf'], $dados['nascimento'], $dados['endereco'], $dados['disponibilidade'], $dados['sexo'], $dados['genero'], $dados['status'], $dados['regimeContratacao'], $dados['regimeTrabalho'], $dados['nivelSenioridade'], $dados['nivelHierarquia'], $habilidades, $beneficios);
        $candidato->setId($dados['id']);
        return $candidato;
    }

    public static function salvar($candidato)
    {
        $pdo = static::conectarDB();

        $cpfSoNumero = preg_replace('/\D/', '', $candidato->getCpf());

        if (empty($candidato->getId())) {
            if (!static::verificar($candidato->getCpf(), $candidato->getEmail(), $candidato->getSenha())) {
                $senhaHash = password_hash($candidato->getSenha(), PASSWORD_ARGON2ID);
                $sql = "INSERT INTO candidato (nome, email, senha, cpf, nascimento, endereco, disponibilidade, sexo, genero, status, regimeContratacao, regimeTrabalho, nivelSenioridade, nivelHierarquia)
                        VALUES (\"{$candidato->getNome()}\", \"{$candidato->getEmail()}\", \"{$senhaHash}\", '$cpfSoNumero', \"{$candidato->getNascimento()}\", \"{$candidato->getEndereco()}\", \"{$candidato->getDisponibilidade()}\", \"{$candidato->getSexo()}\", \"{$candidato->getGenero()}\", \"{$candidato->getStatus()}\", \"{$candidato->getRegimeContratacao()}\", \"{$candidato->getRegimeTrabalho()}\", \"{$candidato->getNivelSenioridade()}\", \"{$candidato->getNivelHierarquia()}\" )";
            } else {
                die('Dados repetidos!');
            }
        } else {
            $sql = "UPDATE candidato SET ";
            $sql .= "nome = '{$candidato->getNome()}', ";
            $sql .= "email = '{$candidato->getEmail()}', ";
            $sql .= "senha = '{$candidato->getSenha()}', ";
            $sql .= "cpf = '$cpfSoNumero', ";
            $sql .= "nascimento = '{$candidato->getNascimento()}', ";
            $sql .= "endereco = '{$candidato->getEndereco()}', ";
            $sql .= "disponibilidade = '{$candidato->getDisponibilidade()}', ";
            $sql .= "sexo = '{$candidato->getSexo()}', ";
            $sql .= "genero = '{$candidato->getGenero()}', ";
            $sql .= "status = '{$candidato->getStatus()}', ";
            $sql .= "regimeContratacao = '{$candidato->getRegimeContratacao()}',";
            $sql .= "regimeTrabalho = '{$candidato->getRegimeTrabalho()}',";
            $sql .= "nivelSenioridade = '{$candidato->getNivelSenioridade()}',";
            $sql .= "nivelHierarquia = '{$candidato->getNivelHierarquia()}' ";
            $sql .= "WHERE id = '{$candidato->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($candidato->getId())) {
            $candidato->setId($pdo->lastInsertId());
        }

        $sql = "DELETE FROM candidato_habilidade WHERE candidato_id = {$candidato->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $sql = "DELETE FROM candidato_beneficio WHERE candidato_id = {$candidato->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        foreach ($candidato->getHabilidades() as $habilidade) {
            $sql = "INSERT INTO candidato_habilidade (candidato_id, habilidade_id) VALUES ({$candidato->getId()}, {$habilidade->getId()})";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }

        foreach ($candidato->getBeneficios() as $beneficio) {
            $sql = "INSERT INTO candidato_beneficio (candidato_id, beneficio_id) 
                    VALUES ({$candidato->getId()}, {$beneficio->getId()})";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        }
    }

    public static function deletar($candidato)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM candidato WHERE id = {$candidato->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($id)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM candidato WHERE id = $id ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;

        while ($candidato = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($candidato);
        }

        return $retorno;
    }

    public static function listar()
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM candidato";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($candidato = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($candidato);
        }

        return $retorno;
    }

    public static function autenticar(string $email, string $senha)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM candidato WHERE email = '$email'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;

        while ($candidato = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($senha, $candidato['senha'])) {
                $retorno = static::preencher($candidato);
            }
        }

        return $retorno;
    }

    public static function verificar($cpf, $email, $senha)
    {
        $min = 0;
        $maxcpf = 11;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            FlashMessage::addMessage('Usuário inválido (usuário precisa ser um email)', FlashMessage::FLASH_ERROR);
            header('Location: /candidato/cadastrar');
            die();
        } elseif (strlen($cpf) != $maxcpf || strlen($email) < $min) {
            FlashMessage::addMessage('CPF com quantidade de caracteres não permitida', FlashMessage::FLASH_ERROR);
            header('Location: /candidato/cadastrar');
            die();
        } elseif (strlen($senha) < 8) {
            FlashMessage::addMessage('Senha não atende ao padrão, deve ter no mínimo 8 caracteres', FlashMessage::FLASH_ERROR);
            header('Location: /candidato/cadastrar');
            die();
        } else {
            $pdo = static::conectarDB();

            $sql = "SELECT COUNT(1) AS Total FROM candidato WHERE candidato.cpf LIKE '$cpf' OR candidato.email LIKE '$email'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();


            $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

            return $totalDeRegistros['Total'] != 0;
        }
    }
}
