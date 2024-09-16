<?php
    class LoginModel {
        public $conn;
        public function __construct() {
            global $conn;
            require("connect.php");
            $this->conn = $conn;
        }

        private function doQuery($array, $sql, $bind) {
            foreach (array_keys($array) as $key) { $destinationArray[] = $key; }

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param($bind, array_map(fn($key) => $array[$key], $destinationArray));

            if ($stmt->execute()) {
                return "Sem erros";
            } else {
                return "Erro ao inserir dados: " . $stmt->error;
            }
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
            $sql = "SELECT nome, email, matricula, categoria FROM usuario WHERE id = '$id'";
            $result = $this->conn->query($sql);

            // $nome = ""; $categoria = "";

            while ($row = $result->fetch_assoc()) {
                $nome = $row['nome'];
                $email = $row['email'];
                $matricula = $row['matricula'];
                $categoria = $row['categoria'];
            }

            return array("nome" => $nome, "email" => $email, "matricula" => $matricula, "categoria" => $categoria);
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

        public function setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa): string {
            if ($justificativa === "") {
                $justificativa = null;
            }

            $sql = "INSERT INTO refeicao (id_usuario, id_cardapio, id_status_ref, id_justificativa, data_solicitacao, hora_solicitacao, outra_justificativa)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiissss", $idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa);

            if ($stmt->execute()) {
                return "Sem erros";
            } else {
                return "Erro ao inserir dados: " . $stmt->error;
            }
        }

        public function hasRefeicao($idUser, $diaAtual) : bool {
            $sql = "SELECT COUNT(*) FROM refeicao WHERE id_usuario = '$idUser' AND data_solicitacao = '$diaAtual' AND motivo_cancelamento IS null";
            
            $resultado = $this->conn->query($sql);
            $num = $resultado->fetch_assoc();
            $num = $num["COUNT(*)"];

            return $num > 0;
        }

        public function cancelarRefeicao($idUser, $diaAtual, $motivo) : string {
            if ($this->hasRefeicao($idUser, $diaAtual)) {
                $stmt = $this->conn->prepare("UPDATE refeicao SET motivo_cancelamento = ? WHERE id_usuario = ? AND data_solicitacao = ?");
                $stmt->bind_param("sis", $motivo, $idUser, $diaAtual);
        
                if ($stmt->execute()) {
                    return "sucesso";
                } else {
                    return "Erro ao executar a declaração: " . $stmt->error;
                }
            }
            
            return "Nenhuma refeição encontrada para cancelar.";
        }

        public function hasNotification($userId) : bool {
            $sql = "SELECT COUNT(*) FROM notificacao WHERE id_destinatario = '$userId'";
            $resultado = $this->conn->query($sql);
            $num = $resultado->fetch_assoc();
            $num = $num["COUNT(*)"];

            return $num > 0;
        }

        // public function getIdByEnrollment($name) : int {
        //     $sql = "SELECT id FROM usuario WHERE nome = ?";
        //     $stmt = $this->conn->prepare($sql);
            
        //     if ($stmt === false) {
        //         throw new Exception('Erro ao preparar a consulta: ' . $this->conn->error);
        //     }
            
        //     $stmt->bind_param('s', $name);
        //     $stmt->execute();
        //     $stmt->bind_result($id);
        //     $id = null;
            
        //     if ($stmt->fetch()) {
        //         $stmt->close();
        //         return $id;
        //     } else {
        //         $stmt->close();
        //         return null;
        //     }
        // }
        
        public function getAssunto($userId) : array {
            $sql = "SELECT assunto FROM notificacao WHERE id_destinatario = ?";
            $stmt = $this->conn->prepare($sql);
            
            if ($stmt === false) {
                throw new Exception('Erro ao preparar a consulta: ' . $this->conn->error);
            }
            
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $stmt->bind_result($assunto);
            $assuntos = [];
            
            while ($stmt->fetch()) {
                $assuntos[] = $assunto;
            }
            
            $stmt->close();
            return $assuntos;
        }

        public function findName($type, $string) : array {
            $nome = 'vazio';
        
            if ($type == "matricula") {
                $stmt = $this->conn->prepare("SELECT nome, matricula FROM usuario WHERE matricula LIKE ?");
                $stmt->bind_param("s", $string);
            } else {
                $string = "%{$string}%";
                $stmt = $this->conn->prepare("SELECT nome, matricula FROM usuario WHERE nome LIKE ?");
                $stmt->bind_param("s", $string);
            }
        
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nome = $row['nome'];
            }
        
            $stmt->close();
        
            return [''];
        }

        public function checkPass($tempPass, $user) : string {
            $sql = "SELECT COUNT(*) as count FROM usuario WHERE id = '$user' AND senha = MD5('$tempPass')";

            $result = $this->conn->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                $count = $row['count'];

                if ($count > 0) { return "sucess"; } 
                else { return "error"; }
            } else {
                return "Erro na consulta: " . $conn->error;
            }  
        }

        public function changePassword($user, $pass) : string {
            $sql = "UPDATE usuario SET senha = MD5('$pass') WHERE id = '$user'";

            if ($this->conn->query($sql) === TRUE) {
                return "sucesso";
            } else {
                return "Erro ao atualizar a senha: " . $conn->error;
            }
        }

        public function getRefeicoes() : array {
            date_default_timezone_set('America/Sao_Paulo');
            $hoje = date('Y-m-d');
            $sql = "SELECT u.nome, u.matricula, r.hora_solicitacao FROM refeicao r JOIN usuario u ON r.id_usuario = u.id WHERE r.data_solicitacao = '$hoje'";
        

            $resultados = $this->conn->query($sql);
            $valores = array();

            while ($row = mysqli_fetch_assoc($resultados)) {
                $valores[] = $row;
            }

            return $valores;
        }
    }
?>