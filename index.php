<?php session_start();
  if (!isset($_SESSION['logged_in'])) {
    $_SESSION['user'] = "";
    $_SESSION['id_user'] = "";
    $_SESSION['logged_in'] = false;
    $_SESSION['category'] = "";
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo(a)</title>
    <link rel="stylesheet" href="View/style.css">
</head>
<body>
    <header>
        <img src="assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra">
    </header>

    <?php include_once("View/navbar.php"); showNav("landpage"); ?>

    <main class="session-2">
        <img class="texto" src="assets/9e42d98494cc4cb687bf1f0012b58c06.png" alt="BEM-VINDO! EXPLORE E APROVEITE TODOS OS RECURSOS.">
        <a href="View/cardapio.php">
            <button class="custom-button">CARDÁPIO</button>
        </a>
    </main>

    <main class="session-3">
        <div class="box1">
            <div class="box2">
              <div class="title">COMO SURGIU?</div>

              <div class="text">
                <p>O projeto da carteirinha digital, se iniciou em 2023, com o intuito de<br>
                    simplificar o processo de do almoço na escola, proporcionando praticidade e<br>
                    controle aos alunos. Além disso, ele oferece segurança e eficiência para a<br>
                    instituição de ensino, tornando a experiência de refeições na escola muito<br>
                    mais conveniente e agradável.</p>
              </div>
            </div>
            <img src="assets/_0454db25-be52-4019-98c8-a6837e90ff09-removebg-preview.png" alt="Imagem do Boneco" class="image">
          </div>
    </main>

    <main class="session-3">
        <div class="announcements-section">
            <div class="announcements-image">
              <img src="assets/202fb5c3fc9a4a73b3049e546ceb0fc4.png" alt="Imagem de Comunicados" class="announcements-image">
            </div>
            <div class="announcements-content">
              <div class="announcements-title">COMUNICADOS</div>
              <div class="separator"> <img src="assets/e9b3f7bfb99641acba8a73b3b29a33bc.png"> </div><br>
              <div class="announcements-subtitle">TÍTULO</div><br>
              <div class="announcements-text">
                <p>Informações sobre os comunicados vão aqui.</p>
              </div>
            </div>
          </div>
    </main>

    <main class="session-4">
        <div class="menu-section">
            <div class="menu-title">CARDÁPIO?</div>

            <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png"> </div>
        
            <div class="menu-items">
              <div class="menu-item">
                <img src="assets/6da0cc15731a428a9e2cf1767f46190f.png" alt="Imagem do Almoço" class="menu-image">
                <div>
                  <div class="menu-name">Almoço</div>
                  <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png"> </div><br>
                  <div class="menu-info">
                    <p>Todo dia diversas opções diferente.</p>
                  </div>
                </div>
              </div>
        
              <div class="menu-item">
                <img src="assets/7732604ec55c471e850c0151ec6b1697.png" alt="Imagem do Complemento" class="menu-image">
                <div>
                  <div class="menu-name">Complemento</div>
                  <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png"> </div><br>
                  <div class="menu-info">
                    <p>Diversas opções, como saladas e entre outros.</p>
                  </div>
                </div>
              </div>
        
              <div class="menu-item">
                <img src="assets/d362a44164f44a24bbb327a5d7208dd6.png" alt="Imagem da Sobremesa" class="menu-image">
                <div>
                  <div class="menu-name">Sobremesa</div>
                  <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png"> </div><br>
                  <div class="menu-info">
                    <p>Ótimos acompanhamentos para a sua refeição.</p>
                  </div>
                </div>
              </div>
    </main>

    <footer>
        <div>
          <img src="assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo">
        </div>
        <div class="copyright">
          <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia
            Campus Seabra</p>
        </div>
      </footer>
    <script src="View/script.js"></script>
</body>
</html>