<?php
    function editJson() {
        $caminhoArquivo = './dados.json';

        $jsonStringOrigem = file_get_contents($caminhoArquivo);

        $arrayDados = json_decode($jsonStringOrigem, true);
        
        unset($arrayDados['img1']);

        for ($c = 1; $c < 5; $c++) {
            $new = $c + 1;
            $arrayDados["img{$c}"] = $arrayDados["img{$new}"];
            unset($arrayDados["img{$new}"]);
        }

        $jsonStringAtualizado = json_encode($arrayDados);
        file_put_contents($caminhoArquivo, $jsonStringAtualizado);
    }

    function createJson($indice, $caminho) {
        // DADOS DO JSON
        $data = $_POST['data-publicacao'];
        $titulo = $_POST['titulo'];
        $link = $_POST['link'];
        //

        $caminhoArquivo = './dados.json';

        $array = array(
            "img{$indice}" => array(
                'titulo' => $titulo,
                'link' => $link,
                'data_publicacao' => $data,
                'index' => "img" . $indice
            )
        );

        if (file_exists($caminhoArquivo)) {
            $jsonStringOrigem = file_get_contents($caminhoArquivo);

            $arrayDados = json_decode($jsonStringOrigem, true);

            $mergedArray = array_merge($arrayDados, $array);
            $mergedJsonString = json_encode($mergedArray);
            file_put_contents($caminhoArquivo, $mergedJsonString);
        } else {
            $jsonString = json_encode($array);
            file_put_contents($caminhoArquivo, $jsonString);
        }

    }

    function getNum() {
        $caminhoPasta = './images';
        $listaArquivos = scandir($caminhoPasta);
        $listaArquivos = array_diff($listaArquivos, array('.', '..'));
        $numArquivos = count($listaArquivos);
        return $numArquivos;
    }

    function renameAll() {
        $diretorio = "./images";

        for ($c = 2; $c < 6; $c++) {
            $diretorio = "./images/";
            $padraoNome = "img{$c}.*";

            $listaArquivos = glob($diretorio . $padraoNome);
            if (!empty($listaArquivos)) {
                foreach ($listaArquivos as $caminhoAtual) {
                    $nomeCompleto = basename($caminhoAtual);
                    $infoArquivo = pathinfo($nomeCompleto);

                    $extensao = $infoArquivo['extension'];
                    $caminhoAtual = $diretorio . $nomeCompleto;
                    $indice = $c - 1;
                    $novoCaminho = "{$diretorio}img{$indice}.{$extensao}";

                    rename($caminhoAtual, $novoCaminho);
                }
            }
        }
    }

    function saveImg() {
        $diretorioDestino = "images/";
        $numArquivos = getNum() + 1;
        $nomeArquivo = "img{$numArquivos}" . "." . pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $caminhoCompleto = $diretorioDestino . $nomeArquivo;

        if (getNum() != 5) {
            if (move_uploaded_file($_FILES['imagem']["tmp_name"], $caminhoCompleto)) {
                echo "Upload realizado com sucesso. O arquivo foi salvo em: " . $caminhoCompleto;
                createJson(getNum(), $caminhoCompleto);

            } else {
                echo "Erro ao salvar o arquivo.";
            }
        } else {
            editJson();
            $diretorio = "uploads/";
            $padraoNome = "img1.*";

            $listaArquivos = glob($diretorio . $padraoNome);

            foreach ($listaArquivos as $arquivo) {
                if (is_file($arquivo)) {
                    unlink($arquivo);
                    echo "Arquivo excluído: " . $arquivo . "<br>";
                }
            }

            renameAll();
            saveImg();
        }
    }

    saveImg();
    header("Location: ../../index.php");
?>