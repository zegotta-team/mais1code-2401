<?php

abstract class UsuarioDTO implements DTOInterface
{
    use DbTrait;

    public static function preencher($dados)
    {
        $empresa = EmpresaDTO::recuperar($dados['empresa_id']);
        $usuario = new Usuario($empresa, $dados['cpf'], $dados['nome'], $dados['email'], $dados['senha'], $dados['tipo']);
        $usuario->setId($dados['id']);
        return $usuario;
    }

    public static function salvar($usuario)
    {

        $pdo = static::conectarDB();

        $cpfSoNumero = preg_replace('/\D/', '', $usuario->getCpf());

        if (empty($usuario->getId())) {
            //            if (!static::verificaDadosExistentes($usuario->getNome(), $usuario->getCnpj(), $usuario->getUsuario())) {
            $sql = "INSERT INTO usuario(empresa_id, cpf, nome, email, senha)
                    VALUES (\"{$usuario->getEmpresa()->getId()}\", '$cpfSoNumero', \"{$usuario->getNome()}\", \"{$usuario->getEmail()}\", \"{$usuario->getSenha()}\")";
            //            } else {
            //                return null;
            //            }
        } else {
            $sql = "UPDATE usuario SET ";
            $sql .= "empresa_id = '{$usuario->getEmpresa()->getId()}', ";
            $sql .= "cpf = '$cpfSoNumero', ";
            $sql .= "nome = '{$usuario->getNome()}', ";
            $sql .= "email = '{$usuario->getEmail()}', ";
            $sql .= "senha = '{$usuario->getSenha()}' ";
            $sql .= "WHERE id = '{$usuario->getId()}' ";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        if (empty($usuario->getId())) {
            $usuario->setId($pdo->lastInsertId());
        }
    }

    public static function deletar($usuario)
    {
        $pdo = static::conectarDB();

        $sql = "DELETE FROM usuario WHERE id = {$usuario->getId()}";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    public static function recuperar($id)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM usuario WHERE id = $id ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno = static::preencher($usuario);
        }

        return $retorno;
    }

    public static function listar($empresaId = '')
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM usuario WHERE 1 ";
        if (!empty($empresaId)) {
            $sql .= "AND empresa_id = $empresaId ";
        }
        $sql .= "ORDER BY nome ASC ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = [];
        while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $retorno[] = static::preencher($usuario);;
        }

        return $retorno;
    }

    public static function autenticar(string $email, string $senha)
    {
        $pdo = static::conectarDB();

        $sql = "SELECT * FROM usuario WHERE email = '$email' ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $retorno = null;
        while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($senha, $usuario['senha'])) {
                $retorno = static::preencher($usuario);
            }
        }

        return $retorno;
    }

}
