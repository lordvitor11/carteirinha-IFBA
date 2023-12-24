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

        public function login($usuario, $senha) : array {
            $sql = "SELECT id, nome, senha, email FROM usuario WHERE nome = '$usuario'";
            $result = $this->conn->query($sql);

            if ($result->num_rows <= 0) {
                $sql = "SELECT id, nome, senha, email FROM usuario WHERE email = '$usuario'";
                $result = $this->conn->query($sql);
            }
            
            $tempUser = ""; $tempPass = ""; $tempEmail = ""; $tempId = "";
            while ($row = $result->fetch_assoc()) {
                $tempUser = $row['nome']; $tempPass = $row['senha']; $tempEmail = $row['email']; $tempId = $row['id'];
            }

            if (($usuario === $tempUser || $usuario === $tempEmail) && MD5($senha) === $tempPass) {
                return array('situacao' => 'aprovado', 'id' => $tempId);
            } else {
                return array('situacao' => 'desaprovado', 'id' => null);
            }
        }

        public function getUserData($id) : array {
            $sql = "SELECT nome, categoria FROM usuario WHERE id = '$id'";
            $result = $this->conn->query($sql);

            $nome = ""; $categoria = "";

            while ($row = $result->fetch_assoc()) {
                $nome = $row['nome'];
                $categoria = $row['categoria'];
            }

            return array("nome" => $nome, "categoria" => $categoria);
        }

        public function getCardapio() : array {
            $sql = "SELECT *
            FROM cardapio
            WHERE data_refeicao >= (
                SELECT MAX(data_refeicao)
                FROM cardapio
                WHERE dia = 'segunda'
            ) AND data_refeicao <= DATE_ADD((
                SELECT MAX(data_refeicao)
                FROM cardapio
                WHERE dia = 'segunda'
            ), INTERVAL 4 DAY)
            ORDER BY data_refeicao;
            ";

            $result = $this->conn->query($sql);

            $index = 0;

            if ($result->num_rows > 0) {
                $cardapio = array();
                while ($row = $result->fetch_assoc()) {
                    $cardapio[$index] = array(
                        "dia" => $row['dia'],
                        "principal" => $row['principal'], 
                        "acompanhamento" => $row['acompanhamento'], 
                        "sobremesa" => $row['sobremesa']
                    );

                    $index++;
                }

                return $cardapio;
            }
        }
    }
?>