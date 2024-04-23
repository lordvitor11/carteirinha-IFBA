<?php
    class LoginModel {
        public $conn;
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
            $sql = "SELECT * FROM cardapio WHERE ind_excluido = 0 ORDER BY data_refeicao";

            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $cardapio = array_fill(0, 5, null);
                while ($row = $result->fetch_assoc()) {
                    $dia;

                    switch ($row['dia']) {
                        case "segunda":
                            $dia = 0; break;
                        case "terca":
                            $dia = 1; break;
                        case "quarta": 
                            $dia = 2; break;
                        case "quinta":
                            $dia = 3; break;
                        case "sexta":
                            $dia = 4; break;
                    }

                    $cardapio[$dia] = array(
                        "dia" => $row['dia'],
                        "data" => $row['data_refeicao'],
                        "principal" => $row['principal'], 
                        "acompanhamento" => $row['acompanhamento'], 
                        "sobremesa" => $row['sobremesa']
                    );
                }

                for ($c = 0; $c < count($cardapio); $c++) {
                    if ($cardapio[$c] == null) {
                        $diaTemp;
                        switch (array_search($cardapio[$c], $cardapio)) {
                            case 0: 
                                $diaTemp = 'Segunda'; break;
                            case 1:
                                $diaTemp = 'Terça'; break;
                            case 2: 
                                $diaTemp = 'Quarta'; break;
                            case 3:
                                $diaTemp = 'Quinta'; break;
                            case 4:
                                $diaTemp = 'Sexta'; break;
                        }

                        $cardapio[$c] = array(
                            "dia" => $diaTemp,
                            "data" => '',
                            "principal" => '-', 
                            "acompanhamento" => '-', 
                            "sobremesa" => '-'
                        );
                    }
                }

                return $cardapio;
            } else {
                return array(null);
            }
        }

        public function deleteCardapio() : string {
            $sql = "UPDATE cardapio SET ind_excluido = 1 WHERE ind_excluido = 0";

            if ($this->conn->query($sql) === TRUE) {
                return "Sem erros";
            } else {
                return "Erro ao excluir dados do cardápio: " . $this->conn->error;
            }
        }

        public function setCardapio($array) : string {
            foreach ($array as $dia) {
                print_r($dia);
                echo "<br>";
            }
            print_r($array);
            $stmt = $this->conn->prepare("INSERT INTO cardapio (data_refeicao, dia, principal, acompanhamento, sobremesa) VALUES (?, ?, ?, ?, ?)");

            if (!$stmt) {
                return "Erro na preparação da consulta: " . $this->conn->error;
            }

            $stmt->bind_param("sssss", $array['data'], $array['dia'], $array['principal'], $array['acompanhamento'], $array['sobremesa']);

            if (!$stmt->execute()) {
                return "Erro na execução da consulta: " . $stmt->error;
            }

            $stmt->close();

            return "Sem erros";
        }

        public function getTime() : string {
            $sql = "SELECT * FROM horario_padrao WHERE fim_vig IS NULL";
            $result = $this->conn->query($sql);
            $response = ""; 

            while ($row = $result->fetch_assoc()) { $response = $row['horario']; }
            return $response;
        }

        public function setDefaultTime($data, $horario) : string {
            $stmt = $this->conn->prepare("INSERT INTO tabela_temporaria (inicio_vig, horario) VALUES (?, ?)");

            if (!$stmt) {
                return "Erro na preparação da consulta: " . $this->conn->error;
            }

            $stmt->bind_param("ss", $data, $horario);

            if (!$stmt->execute()) {
                return "Erro na execução da consulta: " . $stmt->error;
            }

            $stmt->close();

            return "Sem erros";
        }
    }
?>