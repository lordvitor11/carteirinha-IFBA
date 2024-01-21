<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="View/style.css">
    <title>Início</title>
</head>
<body>
    <header class="session-1"> <a href='https://portal.ifba.edu.br/seabra' target='_blank'> <img src='assets/1b1210fdf4454600bea220983da0cc63.png' alt='logo-ifba-seabra' draggable='false'> </a> </header>

    <?php include_once("View/process/navbar.php"); showNav("landpage"); ?>

    <main class="session-2">
        <img class="texto" src="assets/9e42d98494cc4cb687bf1f0012b58c06.png" alt="BEM-VINDO! EXPLORE E APROVEITE TODOS OS RECURSOS." draggable="false">
        <a href="View/cardapio.php">
            <button class="custom-button">CARDÁPIO</button>
        </a>
    </main>

    <main class="session-3">
        <div class="box1">
            <div class="box2">
            <div class="title">COMO SURGIU?</div>
            <div class="text">
                <p>O projeto da carteirinha digital iniciou-se em 2023, com o intuito de simplificar o processo de almoço na escola, proporcionando praticidade e controle aos alunos. Além disso, ele oferece segurança e eficiência para a instituição de ensino, tornando a experiência de refeições na escola muito mais conveniente e agradável.</p>
            </div>
            </div>
            <img src="assets/_0454db25-be52-4019-98c8-a6837e90ff09-removebg-preview.png" alt="Imagem do Boneco" class="image" draggable="false">
        </div>
    </main>

    <div class="session-4">
        <h4 class="comunicados">COMUNICADOS</h4>
        <div class="card">
            <div class="top">
                <div class="userDetails">
                    <div class="profile_img">
                        <img src="assets/profile_instagram.png" class="cover">
                    </div>
                    <h3>IFBA Seabra<br><span>Seabra, Bahia</span></h3>
                </div>
                <div>
                    <img src="assets/dot.png" class="dot">
                </div>
            </div>
            <div class="imgBx">
                <div class="carousel-container">
                    <div class="carousel">
                        <?php
                        $carouselImages = [
                            'assets/image1.jpeg' => 'https://www.example.com/link1',
                            'assets/image2.jpeg' => 'https://www.example.com/link2',
                            'assets/image3.jpeg' => 'https://www.example.com/link3',
                        ];
        
                        foreach ($carouselImages as $image => $link) {
                            echo "<a href='$link' target='_blank'><img src='$image' alt='Carousel Image'></a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="actionBtns">
                <div class="left">
                    <img src="assets/heart.png" class="heart">
                    <img src="assets/comment.png">
                    <img src="assets/share.png">
                </div>
                <div class="right">
                    <img src="assets/bookmark.png">
                </div>
            </div>
        </div>
    </div>

    <div class="session-4-1">
        <a href="View/comunicados-admin.php">
            <button class="custom-button-2">GERENCIAR</button>
        </a>
    </div>
    </div>

    <main class="session-5">
        <div class="menu-section">
            <div class="menu-title">CARDÁPIO?</div>

            <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png" draggable="false"> </div>
            
            <div class="menu-items">
                <div class="menu-item">
                <img src="assets/6da0cc15731a428a9e2cf1767f46190f.png" alt="Imagem do Almoço" class="menu-image" draggable="false">
                <div>
                    <div class="menu-name">Almoço</div>
                    <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png" draggable="false"> </div><br>
                    <div class="menu-info">
                    <p>Todo dia diversas opções diferentes.</p>
                    </div>
                </div>
                </div>
                
                <div class="menu-item">
                <img src="assets/7732604ec55c471e850c0151ec6b1697.png" alt="Imagem do Complemento" class="menu-image" draggable="false">
                <div>
                    <div class="menu-name">Complemento</div>
                    <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png" draggable="false"> </div><br>
                    <div class="menu-info">
                    <p>Diversas opções, como saladas e entre outros.</p>
                    </div>
                </div>
                </div>
                
                <div class="menu-item">
                <img src="assets/d362a44164f44a24bbb327a5d7208dd6.png" alt="Imagem da Sobremesa" class="menu-image" draggable="false">
                <div>
                    <div class="menu-name">Sobremesa</div>
                    <div class="separator2"> <img src="assets/23fcc2516acc4eacad3a22096338e5a2.png" draggable="false"> </div><br>
                    <div class="menu-info">
                    <p>Ótimos acompanhamentos para a sua refeição.</p>
                  </div>
                </div>
              </div>
    </main>

    <footer class="rodape">
        <div>
        <img src="assets/1b1210fdf4454600bea220983da0cc63.png" alt="logo-ifba-seabra" class="logo" draggable="false">
        </div>
        <div class="copyright">
        <p>&copy; 2023 | IFBA - Instituto Federal de Educação, Ciência e Tecnologia da Bahia Campus Seabra</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="view/script.js"></script>
</body>
</html>
