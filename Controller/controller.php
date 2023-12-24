<?php
    class LoginController {
        public function __construct() {
            require("../Model/model.php");
            $this->model = new LoginModel();
        }

        public function processarLogin($usuario, $senha) {
            if ($this->model->hasRegistry($usuario, $senha)) {
                $response = $this->model->login($usuario, $senha);
                if ($response['situacao'] == "aprovado") {
                    return array("situacao" => "aprovado", "id" => $response['id']);
                } else {
                    return array("situacao" => "desaprovado", "id" => null);
                }
            } else {
                return array("situacao" => "desaprovado", "id" => null);
            }
        }

        public function getUserData($id): array {
            return $this->model->getUserData($id);
        }

        public function getCardapio() : array {
            return $this->model->getCardapio();
        }
    }
?>