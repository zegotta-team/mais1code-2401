<?php

/**
 * @noinspection PhpUnused
 */

class UsuarioController
{
    public function login()
    {
        Session::iniciaSessao();

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $remember = isset($_POST['remember_me']);

        if ($remember) {
            setcookie(TipoUsuarioEnum::EMPRESA->session_key(), $email, time() + 3600 * 24 * 30 * 12 * 100, '/');
        } else {
            setcookie(TipoUsuarioEnum::EMPRESA->session_key(), "", time() - 3600, '/');
        }

        $usuario = UsuarioDTO::autenticar($email, $senha);

        if (!empty($usuario)) {
            header("Location: " . TipoUsuarioEnum::EMPRESA->home());
            Session::set(TipoUsuarioEnum::EMPRESA->session_key(), $usuario);
        } else {
            header("Location: /autenticacao/?tab=" . TipoUsuarioEnum::EMPRESA->login_tab());
            Session::clear(TipoUsuarioEnum::EMPRESA->session_key());
            FlashMessage::addMessage('Não foi possível efetuar sua autenticação.<br>Verifique seus dados e tente novamente.', FlashMessageType::ERROR);
        }
    }

    public function index()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $usuarios = UsuarioDTO::listar(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId());
        View::renderizar('usuario/index', compact('usuarios'));
    }

    public function salvar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        if (empty($_POST['usuarioId'])) {
            $usuario = new Usuario(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa(), $_POST['cpf'], $_POST['nome'], $_POST['email'], $_POST['senha'], TipoUsuarioEnum::EMPRESA->value);
        } else {
            $usuario = UsuarioDTO::recuperar($_POST['usuarioId']);

            if (empty($usuario)) {
                die('Usuario não encontrado');
            }

            if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $usuario->getEmpresa()->getId()) {
                die('Sai pilantra, o usuario não é da sua turma');
            }

            $usuario->setNome($_POST['nome'])
                ->setCpf($_POST['cpf'])
                ->setEmail($_POST['email']);
        }

        UsuarioDTO::salvar($usuario);

        header('Location: /usuario');
    }

    public function editar()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $idUsuario = $_GET['id'];
        $usuarioEdicao = UsuarioDTO::recuperar($idUsuario);

        if (empty($usuarioEdicao)) {
            die('Usuario não encontrada');
        }

        if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $usuarioEdicao->getEmpresa()->getId()) {
            die('Sai pilantra, usuario não é da sua turma');
        }

        View::renderizar('usuario/index', compact('usuarioEdicao'));
    }

    public function trocarSenha()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        View::renderizar('usuario/trocarsenha');
    }

    public function salvarSenha()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $usuario = UsuarioDTO::recuperar(Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getId());
        $usuario->setSenha(password_hash($_POST['senha'], PASSWORD_ARGON2ID));
        UsuarioDTO::salvar($usuario);
        header('Location: /usuario');
    }

    public function excluir()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        $idUsuario = $_GET['id'];

        $usuarioExclusao = UsuarioDTO::recuperar($idUsuario);

        if (empty($usuarioExclusao)) {
            die('Usuario não encontrado');
        }

        if (Session::get(TipoUsuarioEnum::EMPRESA->session_key())->getEmpresa()->getId() !== $usuarioExclusao->getEmpresa()->getId()) {
            die('Sai pilantra, o usuario não é da sua turma');
        }

        UsuarioDTO::deletar($usuarioExclusao);
        header('Location: /usuario');
    }

    public function detalhesJson()
    {
        Session::exigeSessao([TipoUsuarioEnum::EMPRESA]);

        header('Content-type: application/json');

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (empty($data)) {
            echo json_encode([]);
            die();
        }

        $id_usuario = $data['id'];
        $usuario = UsuarioDTO::recuperar($id_usuario);

        echo json_encode($usuario->toArray());
    }
}
