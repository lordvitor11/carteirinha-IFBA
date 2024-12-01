<?php
    class LoginModel {
        public $conn;
        public function __construct() {
            global $conn;
            require("connect.php");
            $this->conn = $conn;
        }

        private function doQuery(array $params, string $sql, string $bind): string {
            $stmt = $this->conn->prepare($sql);
        
            if (!$stmt) {
                return "Erro na preparação da consulta: " . $this->conn->error;
            }
        
            $stmt->bind_param($bind, ...array_values($params));
        
            if ($stmt->execute()) {
                return "Sem erros";
            } else {
                return "Erro ao executar a consulta: " . $stmt->error;
            }
        }

        public function hasRegistry($usuario): bool {
            $sql = "SELECT COUNT(*) as count FROM usuario WHERE nome = ? OR email = ?";
            $stmt = $this->conn->prepare($sql);
        
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $this->conn->error);
            }
        
            $stmt->bind_param("ss", $usuario, $usuario);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
        
            return $count > 0;
        }
        
        public function login($usuario, $senha): array {
            $sql = "SELECT id, nome, senha, email FROM usuario WHERE nome = ? OR email = ?";
            $stmt = $this->conn->prepare($sql);
        
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $this->conn->error);
            }
        
            $stmt->bind_param("ss", $usuario, $usuario);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tempPass = $row['senha'];
        
                if (md5($senha) === $tempPass) {
                    $stmt->close();
                    return ['situacao' => 'aprovado', 'id' => $row['id']];
                }
            }
        
            $stmt->close();
            return ['situacao' => 'desaprovado', 'id' => null];
        }
        
        public function getUserData($id): array {
            $sql = "SELECT nome, email, matricula, categoria FROM usuario WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
        
            if (!$stmt) {
                throw new Exception("Erro na preparação da consulta: " . $this->conn->error);
            }
        
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($row = $result->fetch_assoc()) {
                $stmt->close();
                return [
                    "nome" => $row['nome'],
                    "email" => $row['email'],
                    "matricula" => $row['matricula'],
                    "categoria" => $row['categoria']
                ];
            }
        
            $stmt->close();
            return [];
        }
        
        public function getCardapio(): array {
            $sql = "SELECT dia, data_refeicao, principal, acompanhamento, sobremesa FROM cardapio WHERE ind_excluido = 0 ORDER BY data_refeicao";
            $result = $this->conn->query($sql);
            
            $cardapio = array_fill(0, 5, [
                "dia" => '',
                "data" => '',
                "principal" => '-',
                "acompanhamento" => '-',
                "sobremesa" => '-'
            ]);
        
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $diaIndex = match ($row['dia']) {
                        "segunda" => 0,
                        "terca" => 1,
                        "quarta" => 2,
                        "quinta" => 3,
                        "sexta" => 4,
                        default => null,
                    };
                    if ($diaIndex !== null) {
                        $cardapio[$diaIndex] = [
                            "dia" => ucfirst($row['dia']),
                            "data" => $row['data_refeicao'],
                            "principal" => $row['principal'],
                            "acompanhamento" => $row['acompanhamento'],
                            "sobremesa" => $row['sobremesa']
                        ];
                    }
                }
            }
        
            // print_r($cardapio); exit;
            return $cardapio;
        }
        
        public function deleteCardapio(int $func = 0): string {
            $sql = $func === 0 
                ? "UPDATE cardapio SET ind_excluido = 1 WHERE ind_excluido = 0" 
                : "DELETE FROM cardapio ORDER BY id DESC LIMIT 5";
        
            return $this->executeQuery($sql, "Erro ao excluir dados do cardápio");
        }
        
        private function executeQuery(string $sql, string $errorMessage): string {
            if ($this->conn->query($sql) === TRUE) {
                return "Sem erros";
            } else {
                return $errorMessage . ": " . $this->conn->error;
            }
        } 

        public function setCardapio(array $data): string {
            $stmt = $this->conn->prepare("INSERT INTO cardapio (data_refeicao, dia, principal, acompanhamento, sobremesa) VALUES (?, ?, ?, ?, ?)");
            
            if (!$stmt) {
                return "Erro na preparação da consulta: " . $this->conn->error;
            }
        
            $stmt->bind_param("sssss", $data['data'], $data['dia'], $data['principal'], $data['acompanhamento'], $data['sobremesa']);
            
            return $stmt->execute() ? "Sem erros" : "Erro na execução da consulta: " . $stmt->error;
        }

        public function getTime(): string {
            $sql = "SELECT horario FROM horario_padrao WHERE fim_vig IS NULL";
            $result = $this->conn->query($sql);
            
            return $result->num_rows > 0 ? $result->fetch_assoc()['horario'] : '';
        }
        

        public function setDefaultTime(string $data, string $horario): string {
            $totalRegistros = $this->conn->query("SELECT COUNT(*) FROM horario_padrao")->fetch_row()[0];
        
            if ($totalRegistros > 0) {
                $registro = $this->conn->query("SELECT * FROM horario_padrao WHERE id = '$totalRegistros'")->fetch_assoc();
                
                if (!$registro) {
                    return "Nenhum registro encontrado.";
                }
        
                $sql = "UPDATE horario_padrao SET fim_vig = '$data', inicio_vig = '{$registro['inicio_vig']}' WHERE id = '$totalRegistros'";
                if (!$this->conn->query($sql)) {
                    return "Erro ao atualizar dados: " . $this->conn->error;
                }
            }
        
            $sql = "INSERT INTO horario_padrao (inicio_vig, horario) VALUES ('$data', '$horario')";
            
            return $this->conn->query($sql) ? "Sem erros" : "Erro ao inserir dados: " . $this->conn->error;
        }
        
        public function getHistorico(string $id = ""): array {
            $sql = $id === "" 
                ? "SELECT id, data_refeicao FROM cardapio ORDER BY id DESC LIMIT 5" 
                : "SELECT id, data_refeicao FROM cardapio WHERE id <= $id ORDER BY id DESC LIMIT 5";
        
            $resultados = $this->conn->query($sql);
            $valores = ['ids' => [], 'datas' => []];

            // echo "teste"; exit();
        
            while ($row = $resultados->fetch_assoc()) {
                $valores['ids'][] = (int) $row['id'];
                $valores['datas'][] = $row['data_refeicao'];
            }
        
            // array_splice($valores['datas'], 1);

            // print_r($valores['datas']); exit;
        
            $valores['menorId'] = !empty($valores['ids']) ? min($valores['ids']) : null;
            return $valores;
        }
        
        public function getCount(): int {
            $sql = "SELECT COUNT(*) as total FROM cardapio";
            $resultado = $this->conn->query($sql);
            return (int) $resultado->fetch_assoc()['total'];
        }
        
        public function getRegistry(array $ids): array {
            $minId = min($ids);
            $maxId = max($ids);
            $sql = "SELECT * FROM cardapio WHERE id BETWEEN $minId AND $maxId";
        
            $resultados = $this->conn->query($sql);
            return $resultados->fetch_all(MYSQLI_ASSOC);
        }
        
        public function setMeal(int $idUser, int $idCardapio, int $statusRef, ?int $idJustificativa, string $dataSolicitacao, string $horaSolicitacao, ?string $justificativa): string {
            $justificativa = $justificativa ?: null; // Define como null se estiver vazia
        
            $sql = "INSERT INTO refeicao (id_usuario, id_cardapio, id_status_ref, id_justificativa, data_solicitacao, hora_solicitacao, outra_justificativa)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiissss", $idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa);
        
            return $stmt->execute() ? "Sem erros" : "Erro ao inserir dados: " . $stmt->error;
        }

        public function hasRefeicao(int $idUser, string $diaAtual): bool {
            $sql = "SELECT COUNT(*) FROM refeicao WHERE id_usuario = ? AND data_solicitacao = ? AND motivo_cancelamento IS NULL";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("is", $idUser, $diaAtual);
            $stmt->execute();
            
            $resultado = $stmt->get_result();
            $num = $resultado->fetch_row()[0];
        
            return $num > 0;
        }
        
        public function hasNotification(int $userId): bool {
            $sql = "SELECT COUNT(*) FROM notificacao WHERE id_destinatario = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            
            $resultado = $stmt->get_result();
            $num = $resultado->fetch_row()[0];
        
            return $num > 0;
        }
              
        public function getAssunto(int $userId): array {
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
        
        public function findName(string $type, string $string): array {
            $query = $type === "matricula" 
                ? "SELECT nome, matricula FROM usuario WHERE matricula LIKE ?"
                : "SELECT nome, matricula FROM usuario WHERE nome LIKE ?";
            
            $string = $type === "matricula" ? $string : "%{$string}%";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $string);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $nomes = [];
            
            while ($row = $result->fetch_assoc()) {
                $nomes[] = $row['nome'];
            }
        
            $stmt->close();
            return $nomes;
        }
        
        public function checkPass(string $tempPass, int $user): string {
            $sql = "SELECT COUNT(*) as count FROM usuario WHERE id = ? AND senha = MD5(?)";
            $stmt = $this->conn->prepare($sql);
        
            if (!$stmt) {
                return "Erro na preparação da consulta: " . $this->conn->error;
            }
        
            $stmt->bind_param("is", $user, $tempPass);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
        
            return $count > 0 ? "success" : "error";
        }
        
        public function changePassword(int $user, string $pass): string {
            $sql = "UPDATE usuario SET senha = MD5(?) WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
        
            if (!$stmt) {
                return "Erro na preparação da consulta: " . $this->conn->error;
            }
        
            $stmt->bind_param("si", $pass, $user);
            
            if ($stmt->execute()) {
                return "sucesso";
            } else {
                return "Erro ao atualizar a senha: " . $stmt->error;
            }
        }        

        public function getRefeicoes(): array {
            date_default_timezone_set('America/Sao_Paulo');
            $hoje = date('Y-m-d');
            
            $sql = "SELECT u.nome, u.matricula, r.hora_solicitacao 
                    FROM refeicao r 
                    JOIN usuario u ON r.id_usuario = u.id 
                    WHERE r.data_solicitacao = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $hoje);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $valores = $result->fetch_all(MYSQLI_ASSOC);
            
            $stmt->close();
            return $valores;
        }
        
        public function sendNotification($matricula, $remetente, $assunto, $mensagem): string {
            if ($matricula === "") {
                $sql = "INSERT INTO notificacao (id_destinatario, id_remetente, assunto, mensagem)
                        SELECT id, ?, ?, ?
                        FROM usuario
                        WHERE categoria <> 'adm'";
                
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sss", $remetente, $assunto, $mensagem);
            } else {
                $sql = "SELECT id FROM usuario WHERE matricula = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("s", $matricula);
                $stmt->execute();
                
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    $destinatario = $row['id'];
                    $stmt->close();
        
                    $sql = "INSERT INTO notificacao (id_remetente, id_destinatario, assunto, mensagem)
                            VALUES (?, ?, ?, ?)";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("ssss", $remetente, $destinatario, $assunto, $mensagem);
                } else {
                    return "error";
                }
            }
        
            if ($stmt->execute()) {
                $stmt->close();
                return "success";
            } else {
                return "error";
            }
        }        
        
        public function retirarAlmoco($idUser): string {
            $dataAtual = date("Y-m-d");
            $stmt = $this->conn->prepare("SELECT id FROM refeicao WHERE id_usuario = ? AND motivo_cancelamento IS NULL AND data_solicitacao = ?");
            $stmt->bind_param("is", $idUser, $dataAtual);
            $stmt->execute();
            
            return $stmt->get_result()->num_rows > 0 ? "confirmar" : "recusar";
        }

        public function getDataByMatricula($matricula): array {
            $stmt = $this->conn->prepare("SELECT nome, email, matricula, telefone FROM usuario WHERE matricula = ?");
            $stmt->bind_param("s", $matricula);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $userData = $result->fetch_assoc() ?: ["erro"];
            $stmt->close();
            
            return $userData;
        }        

        private function getUserIdByMatricula($matricula) : int {
            $stmt = $this->conn->prepare("SELECT id FROM usuario WHERE matricula = ? LIMIT 1");
            $stmt->bind_param("s", $matricula);
            $stmt->execute();
            
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                // Nenhuma linha encontrada
                throw new Exception("Nenhum usuário encontrado com a matrícula fornecida. $matricula");
            }
            
            $row = $result->fetch_assoc();
            $id = $row['id'] ?? null; // Verifica se a chave 'id' existe
            
            $stmt->close();
        
            if ($id === null) {
                throw new Exception("Erro ao obter o ID do usuário.");
            }
        
            return $id;
        }
        

        private function getNomeById($id) : string {
            $sql = "SELECT nome FROM usuario WHERE id = ? LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $id);

            $stmt->execute();
            $stmt->bind_result($nome);
            $stmt->fetch();
            $stmt->close();
        
            return $nome;   
        }
        

        private function isActiveReserva($idUser) : bool {
            $sql = "SELECT COUNT(*) FROM refeicao WHERE id_usuario = ? AND id_status_ref = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $idUser);
        
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
        
            return $count > 0;
        }


        public function transferirReserva($idUser, $motivo, $matriculaAlvo) : string {
            if ($this->isActiveReserva($idUser)) {
                // echo $matriculaAlvo; exit;
                $idAlvo = $this->getUserIdByMatricula($matriculaAlvo);
                $nomeRemetente = ucfirst($this->getNomeById($idUser));
                $nomeDestinatario = ucfirst($this->getNomeById($idAlvo));
                $assunto = "Transferencia de Almoço";
                $mensagem = "Saudações $nomeDestinatario, o estudante $nomeRemetente fez a você uma solicitação de transferência de almoço!";
                $transferencia = true;

                $sql = "INSERT INTO notificacao (id_remetente, id_destinatario, assunto, mensagem, transferencia) 
                        VALUES (?, ?, ?, ?, ?)";
            
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("iissi", $idUser, $idAlvo, $assunto, $mensagem, $transferencia);
                $result = $stmt->execute();
                $stmt->close();
            
                if ($result) { 
                    return "Notificação enviada"; 
                } else { 
                    return "Falha ao enviar notificação. Por favor, tente novamente."; 
                }
            } else {    
                return "reserva inelegivel";
            }
        }        
    }
?>