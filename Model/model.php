<?php
    class LoginModel {
        public $conn;
        public function __construct() {
            global $conn;
            require("connect.php");
            $this->conn = $conn;
        }

        public function hasRegistry($usuario): bool {
            $sql = "SELECT nome, senha FROM usuario WHERE nome = '$usuario'";

            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                return true;
            } else {
                $sql = "SELECT nome, senha FROM usuario WHERE email = '$usuario'";

                $result = $this->conn->query($sql);

                return $result->num_rows > 0;
            }
        }

        public function login($usuario, $senha) : array {
            $sql = "SELECT * FROM usuario WHERE nome = '$usuario'";
            $result = $this->conn->query($sql);

            if ($result->num_rows <= 0) {
                $sql = "SELECT * FROM usuario WHERE email = '$usuario'";
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
                    $dia = "";

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
                        $diaTemp = "";
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

        public function deleteCardapio($func = 0) : string {
            if ($func == 0) {
                $sql = "UPDATE cardapio SET ind_excluido = 1 WHERE ind_excluido = 0";
            } else {
                $sql = "DELETE FROM cardapio ORDER BY id DESC LIMIT 5";
            }

            if ($this->conn->query($sql) === TRUE) {
                return "Sem erros";
            } else {
                return "Erro ao excluir dados do cardápio: " . $this->conn->error;
            }
        }

        public function setCardapio($array) : string {
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
            $sql = "SELECT count(*) FROM horario_padrao";
            $result = $this->conn->query($sql);

            $row = mysqli_fetch_array($result);
            $totalRegistros = $row[0];


            if ($totalRegistros > 0) {
                $sql = "SELECT * FROM horario_padrao WHERE id = '$totalRegistros'";
                $result = $this->conn->query($sql);
                $valores = array();

                if ($result->num_rows > 0) {
                    $registro = $result->fetch_assoc();
                    array_push($valores, $registro['id'], $registro['inicio_vig'], $registro['fim_vig'], $registro['horario']);
                } else {
                    return "Nenhum registro encontrado.";
                }

                $sql = "UPDATE horario_padrao SET fim_vig = '$data', inicio_vig = '$valores[1]' WHERE id = '$totalRegistros'";
                if ($this->conn->query($sql) !== TRUE) {
                    return "Erro ao excluir dados do cardápio: " . $this->conn->error;
                }
            }

            $sql = "INSERT INTO horario_padrao (inicio_vig, horario) VALUES ('$data', '$horario')";

            if ($this->conn->query($sql) === TRUE) {
                return "Sem erros";
            } else {
                return "Erro ao excluir dados do cardápio: " . $this->conn->error;
            }
        }

        public function getHistorico($id = "", $sql = "") : array {
            if ($id === "") {
                $sql = "SELECT id, data_refeicao FROM cardapio ORDER BY id DESC LIMIT 5";
            } else $sql = "SELECT id, data_refeicao FROM cardapio WHERE id <= $id ORDER BY id DESC LIMIT 5";

            $resultados = $this->conn->query($sql);
            $valores = array(
                'ids' => array(),
                'datas' => array()
            );

            // Adiciona os valores da consulta à array
            while ($row = mysqli_fetch_assoc($resultados)) {
                $valores['ids'][] = intval($row['id']);
                $valores['datas'][] = $row['data_refeicao'];
            }

            for ($c = 1; $c <= count($valores['datas']); $c++) {
                unset($valores['datas'][$c]);
            }

            $valores['menorId'] = min($valores['ids']);
            return $valores;
        }

        public function getCount() : int {
            $sql = "SELECT COUNT(*) FROM cardapio";
            $resultado = $this->conn->query($sql);
            $num = $resultado->fetch_assoc();

            $num = $num["COUNT(*)"];
            return intval($num);
        }

        public function getRegistry($ids) : array {
            $sql = "SELECT * FROM cardapio WHERE id >= {$ids[count($ids) - 1]} AND id <= $ids[0]";

            $resultados = $this->conn->query($sql);
            $valores = array();

            while ($row = mysqli_fetch_assoc($resultados)) {
                $valores[] = $row;
            }

            return $valores;
        }

        public function setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $justificativa): string {
            if ($justificativa === "") {
                $justificativa = null;
            }

            $sql = "INSERT INTO refeicao (id_usuario, id_cardapio, id_status_ref, id_justificativa, data_solicitacao, outra_justificativa)
            VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiisss", $idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $justificativa);

            if ($stmt->execute()) {
                return "Sem erros";
            } else {
                return "Erro ao inserir dados: " . $stmt->error;
            }
        }

        public function getRefeicoes($idUser, $diaAtual) : int {
            $sql = "SELECT count(*) FROM refeicao WHERE id_usuario = $idUser AND data_solicitacao = $diaAtual";

            
        }
    }
?>