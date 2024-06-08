<?php

abstract class CandidatoDTO implements DTOInterface
{
    use DbTrait;

    public static function salvar($candidato)
    {
        $pdo = static::conectarDB();

        $cpfSoNumero = preg_replace('/\D/', '', $candidato->getCpf());

        if (empty($candidato->getId())) {
            if (!static::verificar($candidato->getCpf(), $candidato->getEmail())) {
                $sql = "INSERT INTO candidato (nome, email, senha, habilidades, cpf, nascimento, endereco, disponibilidade, sexo, genero, status) 
                        VALUES (\"{$candidato->getNome()}\", \"{$candidato->getEmail()}\", \"{$candidato->getSenha()}\", \"{$candidato->getHabilidades()}\", '$cpfSoNumero', \"{$candidato->getNascimento()}\", \"{$candidato->getEndereco()}\", \"{$candidato->getDisponibilidade()}\", \"{$candidato->getSexo()}\", \"{$candidato->getGenero()}\", \"{$candidato->getStatus()}\")";
            } else{
                die('Dados repetidos!');
            }
        } else{
            $sql = "UPDATE candidato SET ";
            $sql .= "nome = '{$candidato->getNome()}', ";
            $sql .= "email = '{$candidato->getEmail()}', ";
            $sql .= "senha = '{$candidato->getSenha()}', ";
            $sql .= "habilidades = '{$candidato->getHabilidades()}', ";
            $sql .= "cpf = '$cpfSoNumero', ";
            $sql .= "nascimento = '{$candidato->getNascimento()}', ";
            $sql .= "endereco = '{$candidato->getEndereco()}', ";
            $sql .= "disponibilidade = '{$candidato->getDisponibilidade()}', ";
            $sql .= "sexo = '{$candidato->getSexo()}', ";
            $sql .= "genero = '{$candidato->getGenero()}', ";
            $sql .= "status = '{$candidato->getStatus()}' ";
            $sql .= "WHERE id = '{$candidato->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($candidato->getId())) {
            $candidato->setId($pdo->lastInsertId());
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

        while($candidato = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objCandidato = new Candidato($candidato['nome'], $candidato['email'], $candidato['senha'], $candidato['habilidades'], $candidato['cpf'], $candidato['nascimento'], $candidato['endereco'], $candidato['disponibilidade'], $candidato['sexo'], $candidato['genero'], $candidato['status']);
            $objCandidato->setId($candidato['id']);
            $retorno = $objCandidato;
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
        while($candidato = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objCandidato = new Candidato($candidato['nome'], $candidato['email'], $candidato['senha'], $candidato['habilidades'], $candidato['cpf'], $candidato['nascimento'], $candidato['endereco'], $candidato['disponibilidade'], $candidato['sexo'], $candidato['genero'], $candidato['status']);
            $objCandidato->setId($candidato['id']);
            $retorno[] = $objCandidato;
        }
        
        return $retorno;
    }

    public static function autenticar(string $email, string $senha) 
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM candidato WHERE email = '$email' AND senha = '$senha'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;

        while($candidato = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $objCandidato = new Candidato($candidato['nome'], $candidato['email'], $candidato['senha'], $candidato['habilidades'], $candidato['cpf'], $candidato['nascimento'], $candidato['endereco'], $candidato['disponibilidade'], $candidato['sexo'], $candidato['genero'], $candidato['status']);
            $objCandidato->setId($candidato['id']);
            $retorno = $objCandidato;
        }

        return $retorno;
    } 

    public static function verificar($cpf, $email) 
    {
        $pdo = static::conectarDB();

        $sql = "SELECT COUNT(1) AS Total FROM candidato WHERE candidato.cpf LIKE '$cpf' OR candidato.email LIKE '$email'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $totalDeRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        return $totalDeRegistros['Total'] != 0;
    }
}