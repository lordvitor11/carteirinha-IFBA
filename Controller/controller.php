<?php
    class LoginController {
        public $model;
        public function __construct() {
            $path = realpath(__DIR__ . "/..");
            require($path . "/Model/model.php");
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

        public function deleteCardapio() : string {
            return $this->model->deleteCardapio();
        }

        public function setCardapio($array) : string {
            return $this->model->setCardapio($array);
        }

        public function getTime() : string {
            return $this->model->getTime();
        }
    }
?>