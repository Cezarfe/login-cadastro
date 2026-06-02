```php id="k8p2lm"

<?php
session_start();

if(!isset($_SESSION['lista'])){
    $_SESSION['lista'] = [];
}

/* PÁGINA ATUAL */
$pagina = $_GET['pagina'] ?? 'inicio';

/* CADASTRAR */
if(isset($_POST['salvar'])){

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    if(!empty($titulo) && !empty($descricao)){

        $_SESSION['lista'][] = [
            "titulo" => $titulo,
            "descricao" => $descricao
        ];
    }

    $pagina = 'cadastro';
}

/* PESQUISA */
$resultadoBusca = [];

if(isset($_POST['buscar'])){

    $pesquisa = $_POST['pesquisa'];

    foreach($_SESSION['lista'] as $item){

        if(stripos($item['titulo'], $pesquisa) !== false){
            $resultadoBusca[] = $item;
        }
    }

    $pagina = 'pesquisa';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Principal</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f4f4f4;
}

.topo{
    background:#2196f3;
    color:white;
    padding:15px;
}

.menu{
    width:200px;
    height:100%;
    position:fixed;
    top:0;
    left:0;
    background:#333;
    padding-top:60px;
}

.menu a{
    display:block;
    color:white;
    padding:15px;
    text-decoration:none;
}

.menu a:hover{
    background:#444;
}

.conteudo{
    margin-left:220px;
    padding:20px;
}

.box{
    background:white;
    padding:20px;
    border-radius:10px;
}

.item{
    background:#eee;
    padding:10px;
    margin-top:10px;
    border-radius:8px;
}

input, button{
    padding:10px;
    margin-top:10px;
    width:100%;
}

button{
    background:#2196f3;
    color:white;
    border:none;
    cursor:pointer;
}

</style>
</head>
<body>

<!-- MENU -->
<div class="menu">

    <a href="?pagina=inicio">Início</a>
    <a href="?pagina=cadastro">Cadastrar</a>
    <a href="?pagina=pesquisa">Pesquisar</a>
    <a href="logout.php">Sair</a>

</div>

<!-- CONTEÚDO -->
<div class="conteudo">

    <h2>Sistema</h2>

    <?php if($pagina == 'inicio'): ?>

        <div class="box">
            <h3>Bem-vindo</h3>
            <p>Escolha uma opção no menu.</p>
        </div>

    <?php endif; ?>

    <?php if($pagina == 'cadastro'): ?>

        <div class="box">

            <h3>Cadastrar</h3>

            <form method="POST">

                <input type="text" name="titulo" placeholder="Título" required>

                <input type="text" name="descricao" placeholder="Descrição" required>

                <button type="submit" name="salvar">Salvar</button>

            </form>

            <h3>Lista</h3>

            <?php foreach($_SESSION['lista'] as $item): ?>

                <div class="item">
                    <b><?= $item['titulo'] ?></b><br>
                    <?= $item['descricao'] ?>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <?php if($pagina == 'pesquisa'): ?>

        <div class="box">

            <h3>Pesquisar</h3>

            <form method="POST">

                <input type="text" name="pesquisa" placeholder="Digite o título">

                <button type="submit" name="buscar">Buscar</button>

            </form>

            <?php if(isset($_POST['buscar'])): ?>

                <?php if(count($resultadoBusca) > 0): ?>

                    <?php foreach($resultadoBusca as $r): ?>

                        <div class="item">
                            <b><?= $r['titulo'] ?></b><br>
                            <?= $r['descricao'] ?>
                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <p>Nenhum resultado encontrado.</p>

                <?php endif; ?>

            <?php endif; ?>

        </div>

    <?php endif; ?>

</div>

</body>
</html>
