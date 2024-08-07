<?php

class UsuarioController
{

    public function __construct()
    {
    }

    public function index()
    {
        UsuarioController::exigeSessao();

        $usuarios = UsuarioDTO::listar($_SESSION['usuario']->getEmpresa()->getId());
        View::renderizar('usuario/index', compact('usuarios'));
    }

    public function salvar()
    {
        UsuarioController::exigeSessao();

        if (empty($_POST['usuarioId'])) {
            $usuario = new Usuario($_SESSION['usuario']->getEmpresa(), $_POST['cpf'], $_POST['nome'], $_POST['email'], $_POST['senha'], TipoUsuarioEnum::USUARIO->value);
        } else {
            $usuario = UsuarioDTO::recuperar($_POST['usuarioId']);

            if (empty($usuario)) {
                die('Usuario não encontrado');
            }

            if ($_SESSION['usuario']->getEmpresa()->getId() !== $usuario->getEmpresa()->getId()) {
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
        UsuarioController::exigeSessao();

        $idUsuario = $_GET['id'];
        $usuarioEdicao = UsuarioDTO::recuperar($idUsuario);

        if (empty($usuarioEdicao)) {
            die('Usuario não encontrada');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $usuarioEdicao->getEmpresa()->getId()) {
            die('Sai pilantra, usuario não é da sua turma');
        }

        View::renderizar('usuario/index', compact('usuarioEdicao'));
    }

    public function trocarSenha()
    {
        UsuarioController::exigeSessao();

        View::renderizar('usuario/trocarsenha');
    }

    public function salvarSenha()
    {
        UsuarioController::exigeSessao();

        $usuario = UsuarioDTO::recuperar($_SESSION['usuario']->getId());
        $usuario->setSenha(password_hash($_POST['senha'], PASSWORD_ARGON2ID));
        UsuarioDTO::salvar($usuario);
        header('Location: /usuario');
    }

    public function excluir()
    {
        UsuarioController::exigeSessao();

        $idUsuario = $_GET['id'];

        $usuarioExclusao = UsuarioDTO::recuperar($idUsuario);

        if (empty($usuarioExclusao)) {
            die('Usuario não encontrado');
        }

        if ($_SESSION['usuario']->getEmpresa()->getId() !== $usuarioExclusao->getEmpresa()->getId()) {
            die('Sai pilantra, o usuario não é da sua turma');
        }

        UsuarioDTO::deletar($usuarioExclusao);
        header('Location: /usuario');
    }

    public function login()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $remember = isset($_POST['remember_me']);

        if ($remember) {
            setcookie("usuario", $email, time() + 3600 * 24 * 30 * 12 * 100, '/');
        } else {
            setcookie("usuario", "", time() - 3600, '/');
        }

        $usuario = UsuarioDTO::autenticar($email, $senha);

        if (!empty($usuario)) {
            header('Location: /vaga/');
            $_SESSION['usuario'] = $usuario;
        } else {
            header('Location: /autenticacao/?tab=2');
            $_SESSION['usuario'] = null;
            FlashMessage::addMessage('Falha ao autenticar', FlashMessage::FLASH_ERROR);
        }
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /');
    }

    public static function exigeSessao()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['usuario'])) {
            header("Location: /autenticacao/");
            die();
        }

    }

    public static function renegaSessao()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['usuario'])) {
            header("Location: /vaga/painel");
        }
    }

    public static function estaLogado()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return !empty($_SESSION['usuario']);
    }

    public function detalhes()
    {
        UsuarioController::exigeSessao();
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
