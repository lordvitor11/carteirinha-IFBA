<?php
    require_once "Model/model.php";

    class LoginController {
        public function __construct() {
            $this->model = new LoginModel();
        }

        public function processarLogin($usuario, $senha): string {
            if ($this->model->hasRegistry($usuario, $senha)) {
                return "Logado como $usuario";
            } else {
                return "Usuário inexistente!";
            }
        }
    }
?>