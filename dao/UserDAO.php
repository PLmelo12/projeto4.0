<?php

    require_once("models/User.php");
    require_once("models/Message.php");

    class UserDAO implements UserDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn; //chamando a conexão com o banco 
            $this->url = $url; //chamando a base url
            $this->message = new Message($url); //chamando a mensagem
        }
       

        public function buildUser($data) {

             $user = new User();

             $user->id = $data["id"];
             $user->name = $data["name"]; 
             $user->email = $data["email"];  
             $user->password = $data["password"]; 
             $user->image = $data["image"];   
             $user->token = $data["token"];  
             $user->bio = $data["bio"]; 

             return $user;

        }

        public function create(User $user, $authUser = false) {

            $stmt = $this->conn->prepare("INSERT INTO users(
                    email, name, data_nasc, mae, cpf, genero, celular, cep, bairro, municipio, estado, endereco, numero, password, token 
                ) VALUES (
                    :email, :name, :data_nasc, :mae, :cpf, :genero, :celular, :cep, :bairro, :municipio, :estado, :endereco, :numero, :password, :token
                )");

            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":data_nasc", $user->data_nasc);
            $stmt->bindParam(":mae", $user->mae);
            $stmt->bindParam(":cpf", $user->cpf);
            $stmt->bindParam(":genero", $user->genero);
            $stmt->bindParam(":celular", $user->celular);
            $stmt->bindParam(":cep", $user->cep);
            $stmt->bindParam(":bairro", $user->bairro);
            $stmt->bindParam(":municipio", $user->municipio);
            $stmt->bindParam(":estado", $user->estado);
            $stmt->bindParam(":endereco", $user->endereco);
            $stmt->bindParam(":numero", $user->numero);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);
            

            $stmt->execute();

            //autenticar usuário, caso auth seja true
            if($authUser) {

                $this->setTokenToSession($user->token);

            }

        }

        public function update(User $user, $redirect = true) {

            $stmt = $this->conn->prepare("UPDATE users SET
                -- name = :name,
                -- email = :email,
                -- image = :image,
                bio = :bio,
                token = :token
                WHERE id = :id
            ");

            // $stmt->bindParam(":name", $user->name);
            // $stmt->bindParam(":email", $user->email);
            // $stmt->bindParam(":image", $user->image);
            $stmt->bindParam(":bio", $user->bio);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            if($redirect) {

                $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");

            }

        }

        public function verifyToken($protected = false) {

            if(!empty($_SESSION["token"])) {

                //pegar o token da session
                $token = $_SESSION["token"];

                $user = $this->findByToken($token);

                if($user) {

                    return $user;

                } else if($protected) {

                    //redireciona usuário não autenticado
                    $this->message->setMessage("Faça a autenticação para acessar está página", "error", "index.php");

                }

            } else if($protected) {

                //redireciona usuário não autenticado
                $this->message->setMessage("Faça a autenticação para acessar está página", "error", "index.php");

            }

        }

        public function setTokenToSession($token, $redirect = true) {

            //salvar token na session
            $_SESSION["token"] = $token;

            if($redirect) {

                //redireciona para o perfil do usuário
                $this->message->setMessage("Seja bem-vindo.", "success", "editprofile.php");

            }

        }

        public function authenticateUser($email, $password) {

            $user = $this->findByEmail($email);

            if($user) {

                //checar se as senhas batem
                if(password_verify($password, $user->password)) {

                    //gerar um token e inserir na seção
                    $token = $user->generateToken();

                    $this->setTokenToSession($token, false);

                    //atualizar token no usuário
                    $user->token = $token;

                    $this->update($user, false);

                    return true;

                } else {

                    return false;

                }

            } else {

                return false;

            }

        }

        public function findByEmail($email) {

            if($email != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {

                    return false;

                }

            } else {

                return false;

            }

        }

        public function findById($id) {

            if($id != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

                $stmt->bindParam(":id", $id);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {

                    return false;

                }

            } else {

                return false;

            }

        }

        public function findByToken($token) {

            if($token != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {

                    return false;

                }

            } else {

                return false;

            }

        }

        public function destroyToken() {

            //remove o token da session
            $_SESSION["token"] = "";

            //redirecionar e apresentar a mensagem de sucesso
            $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");

        }

        public function changePassword(User $user) {

            $stmt = $this->conn->prepare("UPDATE users SET
                password = :password
                WHERE id = :id
            ");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            //redirecionar e apresentar a mensagem de sucesso
            $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");

        }

    }





    
?>