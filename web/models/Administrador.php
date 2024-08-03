<?php

class Administrador
{

    private $id;
    private $nome;
    private $email;
    private $login;
    private $senha;

    /**
     * @param $nome
     * @param $email
     * @param $login
     * @param $senha
     */
    public function __construct($nome, $email, $login, $senha)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->login = $login;
        $this->senha = $senha;
    }

    public function toArray()
    {
        return [
            'nome' => $this->getNome(),
            'email' => $this->getEmail(),
            'login' => $this->getLogin(),
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Adminstrador
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return Adminstrador
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Adminstrador
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     * @return Adminstrador
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     * @return Adminstrador
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

}