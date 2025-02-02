<?php

    class Message {

        private $url;

        public function __construct($url) {
            $this->url = $url;
        }

        //insere a mensagem
        public function setMessage($msg, $type, $redirect = "index.php") {

            $_SESSION["msg"] = $msg;
            $_SESSION["type"] = $type;

            if($redirect != "back") {
                header("Location: $this->url" . $redirect);
            } else {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        }

        //exibe a mensagem
        public function getMessage() {

            if(!empty($_SESSION["msg"])) {
                return[
                    "msg" => $_SESSION["msg"],
                    "type" => $_SESSION["type"]
                ];
            } else {
                return false;
            }

        }

        //limpar a mensagem
        public function clearMessage() {

            $_SESSION["msg"] = "";
            $_SESSION["type"] = "";

        }

       
    }

?>