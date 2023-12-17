<?php
    class LoginModel {
        public function __construct() {
            require("connect.php");
            $this->conn = $conn;
        }

        public function hasRegistry($usuario, $senha): bool {
            $sql = "SELECT nome, senha FROM usuario WHERE nome = '$usuario'";

            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                return true;
            } else {
                $sql = "SELECT nome, senha FROM usuario WHERE email = '$usuario'";

                $result = $this->conn->query($sql);

                return $result->num_rows > 0 ? true : false;
            }
        }

        public function login($usuario, $senha): string {
            $sql = "SELECT nome, senha, email FROM usuario WHERE nome = '$usuario'";
            $result = $this->conn->query($sql);

            if ($result->num_rows <= 0) {
                $sql = "SELECT nome, senha, email FROM usuario WHERE email = '$usuario'";
                $result = $this->conn->query($sql);
            }
            
            $tempUser = ""; $tempPass = ""; $tempEmail = "";
            while ($row = $result->fetch_assoc()) {
                $tempUser = $row['nome']; $tempPass = $row['senha']; $tempEmail = $row['email'];
            }

            if ($usuario === $tempUser || $usuario === $tempEmail && MD5($senha) === $tempPass) {
                return true;
            } else {
                return false;
            }
        }
    }
?>