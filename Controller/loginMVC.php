<?php
    class Login {
        // Atributos
        public $username;
        public $password;

        // Construtor
        private function __construct($username, $password) {
            $this->username = $username;
            $this->password = $password;
        }

        // Getters e Setters
        public getUsername() {
            return $this->username;
        }

        public getPassword() {
            return $this->password;
        }

        public setUsername($newUsername) {
            $this->username = $newUsername;
        }

        public setPassword($newPassword) {
            $this->password = $newPassword;
        }

        // Métodos
        public verificaDados($username, $password) {}
    }

?>