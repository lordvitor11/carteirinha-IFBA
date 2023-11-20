<?php
    class LoginController {
        private $model; // Objeto do modelo
        private $view;  // Objeto da visão

        public function __construct($model, $view) {
            $this->model = $model;
            $this->view = $view;
        }

        public function processarLogin($email, $senha) {
            
            // Chamar o método do modelo para obter o usuário com base nas credenciais
            $usuario = $this->model->obterUsuarioPorCredenciais($email, $senha);

            // Verificar se o usuário foi encontrado
            if ($usuario) {
                // Usuário autenticado com sucesso, redirecionar ou realizar ações necessárias
                $this->view->mostrarMensagem('Login bem-sucedido');
            } else {
                // Falha na autenticação, exibir mensagem de erro na visão
                $this->view->mostrarMensagem('Credenciais inválidas');
            }
        }
    }
?>
