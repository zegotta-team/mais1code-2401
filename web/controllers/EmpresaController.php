<?php

class EmpresaController
{

    public function __construct()
    {
    }

    public function cadastrar()
    {
        UsuarioController::renegaSessao();

        View::renderizar('empresa/cadastrar', [], 'login');
    }

    public function processaCadastrar()
    {
        UsuarioController::renegaSessao();

        header('Location: /autenticacao');

        if (EmpresaDTO::verificaDadosExistentes($_POST['nome'], $_POST['cnpj'])) {
            FlashMessage::addMessage('Dados repetidos', FlashMessage::FLASH_ERROR);
            die();
        }

        if (!FilialDTO::verificar($_POST['filialCep'], $_POST['filialEstado'])) {

        }

        $empresa = new Empresa($_POST['nome'], $_POST['cnpj'], $_POST['email'], $_POST['descricao'], $_FILES['logo']['tmp_name'] . "|" . $_FILES['logo']['name']);
        EmpresaDTO::salvar($empresa);

        $usuario = new Usuario($empresa, $_POST['usuarioCpf'], $_POST['usuarioNome'], $_POST['usuarioEmail'], password_hash($_POST['usuarioSenha'], PASSWORD_ARGON2ID), TipoUsuarioEnum::USUARIO->value);
        UsuarioDTO::salvar($usuario);

        $filial = new Filial($empresa, $_POST['filialNome'], $_POST['filialCep'], $_POST['filialLogradouro'], $_POST['filialNumero'], $_POST['filialComplemento'], $_POST['filialBairro'], $_POST['filialCidade'], $_POST['filialEstado']);
        FilialDTO::salvar($filial);

    }

    public function editar()
    {
        UsuarioController::exigeSessao();

        View::renderizar('empresa/editar');
    }

    public function processaEditar()
    {
        UsuarioController::exigeSessao();

        $empresa = EmpresaDTO::recuperar($_SESSION['usuario']->getEmpresa()->getId());

        $empresa->setNome($_POST["nome"])
            ->setCNPJ($_POST["cnpj"])
            ->setEmail($_POST["email"])
            ->setDescricao($_POST['descricao']);

        if (!empty($_FILES['logo']['tmp_name']) && $_FILES['logo']['error'] === 0) {
            $empresa->setLogo($_FILES['logo']['tmp_name'] . "|" . $_FILES['logo']['name']);
        }

        EmpresaDTO::salvar($empresa);
        FlashMessage::addMessage('Dados atualizados com sucesso', FlashMessage::FLASH_SUCCESS);

        header('Location: /empresa/editar');
    }

    public function excluir()
    {
        UsuarioController::exigeSessao();

        View::renderizar('empresa/excluir');
    }

    public function processaExcluir()
    {
        UsuarioController::exigeSessao();

        EmpresaDTO::deletar($_SESSION['usuario']->getEmpresa());

        header('Location: /');
    }
}
