<?php
    class LoginController {
        public function __construct() {
            require("../Model/model.php");
            $this->model = new LoginModel();
        }

        public function processarLogin($usuario, $senha): bool {
            if ($this->model->hasRegistry($usuario, $senha)) {
                if ($this->model->login($usuario, $senha)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        public function teste($usuario, $senha):string {
            return $this->model->login($usuario, $senha);
        }
    }
?>