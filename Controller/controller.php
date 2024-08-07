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

        public function setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $justificativa = ""): string {
            return $this->model->setMeal($idUser, $idCardapio, $statusRef, $idJustificativa, $dataSolicitacao, $justificativa);
        }
    }
?>