<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    //sistema de mensageria
    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

    //verifica o tipo do formulário
    $type = filter_input(INPUT_POST, "type");

    //verificação do tipo de formulário
    if($type === "register") {

        //dados que recebe do post
        $email = filter_input(INPUT_POST, "email");
        $name = filter_input(INPUT_POST, "name");
        $data_nasc = filter_input(INPUT_POST, "data_nasc");
        $mae = filter_input(INPUT_POST, "mae");
        $cpf = filter_input(INPUT_POST, "cpf");
        $genero = filter_input(INPUT_POST, "genero");
        $celular = filter_input(INPUT_POST, "celular");
        $cep = filter_input(INPUT_POST, "cep");
        $bairro = filter_input(INPUT_POST, "bairro");
        $municipio = filter_input(INPUT_POST, "municipio");
        $estado = filter_input(INPUT_POST, "estado");
        $endereco = filter_input(INPUT_POST, "endereco");
        $numero = filter_input(INPUT_POST, "numero");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

        //verificação de dados mínimos
        if($email && $name && $data_nasc && $mae && $cpf && $genero && $celular && $cep && $bairro && $municipio && $estado && $endereco && $numero && $password) {

            //verificar se as senhas batem
            if($password === $confirmpassword) {

                //verificar se o e-mail já está cadastrado no sitema
                if($userDao->findByEmail($email) === false) {

                    $user = new User();

                    //criação de token e senha
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    $user->email = $email;
                    $user->name = $name;
                    $user->data_nasc = $data_nasc;
                    $user->mae = $mae;
                    $user->cpf = $cpf;
                    $user->genero = $genero;
                    $user->celular = $celular;
                    $user->cep = $cep;
                    $user->bairro = $bairro;
                    $user->municipio = $municipio;
                    $user->estado = $estado;
                    $user->endereco = $endereco;
                    $user->numero = $numero;
                    $user->password = $finalPassword;
                    $user->token = $userToken;

                    $auth = true;

                    $userDao->create($user, $auth);

                } else {

                     //enviar mensagem de erro, usuário já existe 
                    $message->setMessage("Usuário já cadastrado, tente outro e-mail.", "error", "back");

                }


            } else {

                //enviar mensagem de erro, de senhas não batem 
                $message->setMessage("As senhas não são iguais.", "error", "back");

            }

        } else {

            //enviar mensagem de erro, de dados faltantes
            $message->setMessage("Por favor, preencha todos os campos.", "error", "back");

        }



    } else if($type === "login") {

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        //tenta autenticar usuário
        if($userDao->authenticateUser($email, $password)) {

            $message->setMessage("Seja bem-vindo.", "success", "editprofile.php");

        //redireciona o usuário caso não consiga autenticar
        } else {

            //enviar mensagem de erro, usuário e/ou senha incorretos
            $message->setMessage("Usuário e/ou senha incorretos.", "error", "back");

        }

    } else {

        $message->setMessage("Informações inválidas!", "error", "index.php");

    }

?>