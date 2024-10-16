<?php
    class LoginController {
        public $model;
        public function __construct() {
            $path = realpath(__DIR__ . "/..");
            require($path . "/Model/model.php");
            $this->model = new LoginModel();
        }

        public function processarLogin($usuario, $senha) : array {
            if ($this->model->hasRegistry($usuario)) {
                $response = $this->model->login($usuario, $senha);
                if ($response['situacao'] == "aprovado") {
                    return array("situacao" => "aprovado", "id" => $response['id']);
                } else {
                    return array("situacao" => "desaprovado", "id" => null);
                }
            } else {
                return array("situacao" => "desaprovado", "id" => null);
            }
        }

        public function getUserData($id): array {
            return $this->model->getUserData($id);
        }

        public function getCardapio() : array {
            return $this->model->getCardapio();
        }

        public function deleteCardapio($func = 0) : string {
            return $this->model->deleteCardapio($func);
        }

        public function setCardapio($array) : string {
            return $this->model->setCardapio($array);
        }

        public function getTime() : string {
            return $this->model->getTime();
        }

        public function setDefaultTime($data, $horario) : string {
            return $this->model->setDefaultTime($data, $horario);
        }

        public function getHistorico($id = "") : array {
            return $this->model->getHistorico($id);
        }
        
        public function getCount() : int {
            return $this->model->getCount();
        }

        public function getRegistry($ids) : array {
            return $this->model->getRegistry($ids);
        }

        public function setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa = ""): string {
            return $this->model->setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $horaSolicitacao, $justificativa);
        }

        public function hasRefeicao($idUser, $diaAtual) : bool {
            return $this->model->hasRefeicao($idUser, $diaAtual);
        }

        public function cancelarRefeicao($idUser, $diaAtual, $motivo) : string {
            return $this->model->cancelarRefeicao($idUser, $diaAtual, $motivo);
        }

        public function hasNotification($idUser) : bool {
            return $this->model->hasNotification($idUser);
        }

        // public function getIdByName($name) : int {
        //     return $this->model->getIdByName($name);
        // }

        public function getAssunto($userId) : array {
            return $this->model->getAssunto($userId);
        }
        
        public function findName($type, $string) : string { 
            return $this->model->findName($type, $string);
        }

        public function checkPass($tempPass, $user) : string {
            return $this->model->checkPass($tempPass, $user);
        }

        public function changePassword($user, $pass) : string {
            return $this->model->changePassword($user, $pass);
        }

        public function getRefeicoes() : array {
            return $this->model->getRefeicoes();
        }

        public function sendNotification($matricula, $remetente, $assunto, $mensagem) : string {
            return $this->model->sendNotification($matricula, $remetente, $assunto, $mensagem);
        }

        public function retirarAlmoco($idUser) : string {
            return $this->model->retirarAlmoco($idUser);
        }
    }
?>