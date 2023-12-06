<?php
    class LoginModel {
        public function __construct() {
            require_once("connect.php");
            $this->conn = $conn;
        }

        public function hasRegistry($usuario, $senha): bool {
            $sql = "SELECT * FROM clientes WHERE user = '$usuario'";

            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $tempUser; $tempPass;
                while ($row = $result->fetch_assoc()) {
                    $tempUser = $row['user']; $tempPass = $row['pass'];
                }
                
                if ($usuario == $tempUser && $senha == $tempPass) {
                    return true;
                }
            } else {
                return false;
            }
        }
    }
?>