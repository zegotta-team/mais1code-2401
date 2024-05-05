<?php
function captarNome()
{
    //Nome empresarial ou título do estabelecimento (nome de fantasia)
    //Qual dos dois tipos é necessário no cadastro da empresa

    do {
        echo "Informe o nome da empresa: ";
        $nome = trim(fgets(STDIN));
    } while (is_numeric($nome) || $nome === "");

    return $nome;
}

function captarCNPJ($precisaSerNovo = false)
{
    do {
        echo "Informe o cnpj da empresa: ";
        $cnpj = intval(trim(fgets(STDIN)));

        // Remover caracteres que não são dígitos
        $cnpj = preg_replace('/\D/', '', $cnpj);

        // Verificar se o CNPJ tem exatamente 14 caracteres após remover os não-dígitos
        if (strlen($cnpj) !== 14) { // CNPJ não tem 14 caracteres
            echo "O CNPJ deve ter exatamente 14 caracteres.\n";

        } else { // CNPJ válido
            echo "O CNPJ é válido: $cnpj\n";
        }
    } while (strlen($cnpj) !== 14);

    if ($precisaSerNovo) {

    }

    return $cnpj;
}

function captarTitulo()
{
    do {
        echo "Informe o titulo da vaga: ";
        $titulo = trim(fgets(STDIN));
    } while ($titulo === "");

    return $titulo;
}

function captarUsuario()
{
    //Pensar em como validar se aquele usuario informado já existe ou não, para não haver mais de uma empresa com o mesmo usuario
    //Por exemplo, poderia ser feito uma leitura nos dados armazenados na coluna usuario na tabela empresa do banco de dados, para comparar se o usuario informado no cadastro da empresa é igual a um usuario já existente na tabela

    do {
        echo "Informe o usuario: ";
        $usuario = trim(fgets(STDIN));
    } while ($usuario === "");

    return $usuario;
}

//Após informar o email e a senha, poderia haver uma verificação de código, para validar se aquele email é pertencente da pessoa que está cadastrando a empresa

function captarEmail()
{
    //Além da validação se é um email ou não (Front-end - input do tipo email), precisa validar se é um email existente e ativo na qual possa entrar em contato(verificação de código)

    do {
        echo "Informe o email: ";
        $email = trim(fgets(STDIN));
    } while ($email === "");

    return $email;
}

function captarSenha()
{
    //Quanto a senha, pensar se vai se tratar de uma senha que só tenha números ou será a mistura de letras e números

    do {
        echo "Informe a senha: ";
        $senha = trim(fgets(STDIN)); 
    } while ($senha === "");

    return $senha;
}

function captarDescricao()
{
    do {
        echo "Faça uma descrição: \n";
        $descricao = trim(fgets(STDIN));
    } while ($descricao === "");

    return $descricao;
}

function captarLogo()
{
    //Pode se tratar de um link que leve até uma imagem ou ícone

    echo "Informe o link da logo: ";
    $logo = trim(fgets(STDIN));

    return $logo;
}

//Poderia haver um campo selecionável de endereço, se é um endereço digital ou físico, dependendo do tipo de endereço, iria captar uma informação do tipo diferente, por exemplo, se fosse endereço do tipo físico, poderia abrir outro campo selecionável para escolher o país, estado ou cidade. Se fosse endereço do tipo digital iria abrir um campo onde seria preenchido com texto

function captarEndereco()
{
    //Com relação ao endereço, pode se tratar de um endereço de um lugar físico ou digital

    do {
        echo "Informe o endereço da empresa: ";
        $endereco = trim(fgets(STDIN));
    } while ($endereco === "");

    return $endereco;
}

function captarSalario()
{
    do {
        echo "Informe o salario da vaga: ";
        $salario = intval(trim(fgets(STDIN)));
    } while ($salario === "");

    return $salario;
}

function captarBeneficios()
{
    echo "Informe os beneficios da vaga: ";
    $beneficios = trim(fgets(STDIN));

    return $beneficios;
}

function captarRequisitos()
{
    do {
        echo "Informe os requisitos para a vaga: ";
        $requisitos = trim(fgets(STDIN));
    } while ($requisitos === "");

    return $requisitos;
}

function captarCargaHoraria()
{
    do {
        echo "Informe a carga horária: ";
        $cargaHoraria = intval(trim(fgets(STDIN)));
    } while ($cargaHoraria === "");

    return $cargaHoraria;
}

function editarVaga() {
    do{
        echo "Informe o que deseja consultar: ";
        $filtro = trim(fgets(STDIN));
    
        $results = Vaga::selecionaDados($filtro);
    
        if (!empty($results)) {
            echo "Informação passada pela busca válida. \n";
    
            print_r($results);
    
            do{
                echo "Informe o id da vaga que deseja alterar: ";
                $id = intval(trim(fgets(STDIN)));
            } while($id <= 0);
            //var_dump($id);
        } else{
            echo "Informação passada na busca inválida. Tente novamente! \n";
        }
    
    } while(empty($id));
    
    do{
    
        do{
            echo "Deseja realmente fazer alguma alteração na vaga (sim/nao): ";
            $resposta = trim(fgets(STDIN));
        } while($resposta !== 'sim' && $resposta !== 'nao');
        
        //var_dump($resposta);
    
        if ($resposta == 'sim') {
            do{
                echo "Informe o número do campo que deseja alterar:
                    1 - titulo; 
                    2 - email;
                    3 - salário;
                    4 - benefícios;
                    5 - descrição;
                    6 - requisitos;
                    7 - carga horária. \n";
                $campo = trim(fgets(STDIN));
            } while($campo !== '1' && $campo !== '2' && $campo!== '3' && $campo !== '4' && $campo !== '5' && $campo !== '6' && $campo !== '7');
    
            //var_dump($campo);
    
            if ($campo == 1) {
                $alteracao = 'titulo';
    
                $novoDado = captarTitulo();
            } elseif ($campo == 2) {
                $alteracao = 'email';
    
                $novoDado = captarEmail();
            } elseif ($campo == 3) {
                $alteracao = 'salario';
    
                $novoDado = captarSalario();
            } elseif ($campo == 4) {
                $alteracao = 'beneficios';
    
                $novoDado = captarBeneficios();
            } elseif ($campo == 5) {
                $alteracao = 'descricao';
    
                $novoDado = captarDescricao();
            } elseif ($campo == 6) {
                $alteracao = 'requisitos';
    
                $novoDado = captarRequisitos();
            } elseif ($campo == 7) {
                $alteracao = 'cargaHoraria';
    
                $novoDado = captarCargaHoraria();
            }
    
            //var_dump($novoDado);
    
            if (!empty($alteracao) && !empty($novoDado) && !empty($id)) {
                Vaga::alteraDados($alteracao, $novoDado, $id);
            }
        }
    } while($resposta != 'nao');
    
}

function removerVaga()
{
   try {
        echo "Digite o valor que deseja consultar: ";
        $buscar = trim(fgets(STDIN));
        $results = Vaga::consultarVagas($buscar);

       if (empty($results)) {
           die("Nenhuma vaga encontrada com os termos de busca!\n");
       }

       array_walk($results, function($element){
           echo join("\t", $element);
           echo "\n";
       });

       do {
            echo "Digite o ID da vaga que deseja remover: ";
            $removerVagaID = trim(fgets(STDIN));
       } while (!is_numeric($removerVagaID) || $removerVagaID <= 0 || $removerVagaID == "");

       $existeVaga = false;

       array_walk($results, function($element) use(&$existeVaga, $removerVagaID){
           if ($element['id'] == $removerVagaID) {
               $existeVaga = true;
           }
       });

       if ($existeVaga == false) {
           die("Vaga não existe!\n");
       }

       do {
            echo "Tem certeza? s/n: ";
            $confirmarRemocao = strtolower(trim(fgets(STDIN)));
       } while ($confirmarRemocao != 's' && 
                $confirmarRemocao != 'n' && 
                $confirmarRemocao != 'sim' && 
                $confirmarRemocao != 'nao' && 
                $confirmarRemocao != 'não');

       if ($confirmarRemocao == "s" || $confirmarRemocao == "sim") {
           $results = Vaga::removerVagaDB($removerVagaID);
            echo "Removido com sucesso!\n";
       } else {
            die("Processo interrompido pelo usuário.\n");
       }


   } catch(PDOException $e) {
       echo "Erro: " . $e->getMessage();
   } 
}

function criarEmpresa()
{
    $nome = captarNome();
    $cnpj = captarCNPJ();
    $usuario = captarUsuario();

    if (!Empresa::verificaDadosExistentes($nome, $cnpj, $usuario)) {
        $empresa = new Empresa($nome, $cnpj, $usuario, captarEmail(), captarSenha(), captarDescricao(), captarLogo(), captarEndereco());
        var_dump($empresa);
        $empresa->salvar();
    } else {
        echo "Dados duplicados, verifique e tente novamente\n";
    }
}

function cadastraVaga(){

    $cadastroEmail = captarEmail();
    $cadastroSalario = captarSalario();
    $cadastroBeneficios = captarBeneficios();
    $cadastroDescricao = captarDescricao();
    $cadastroRequisitos = captarRequisitos();
    $cadastroCargaHoraria = captarCargaHoraria();

    $empresa = new Empresa();
    $empresa->listaEmpresas();

    $vaga = new Vaga($empresa, captarTitulo(), $cadastroEmail, $cadastroSalario, $cadastroBeneficios, $cadastroDescricao, $cadastroRequisitos, $cadastroCargaHoraria);
    $vaga->salvar();
}