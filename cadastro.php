<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <style>
        body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    font-family: Arial, sans-serif;
}

.container {
    width: 350px;
    padding: 30px;
    background: #1e293b;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
}

h1 {
    text-align: center;
    color: #8a7bff;
    margin-bottom: 25px;
}

label {
    color: #cbd5f5;
    font-size: 13px;
}

input {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: 1px solid #334155;
    background: #0f172a;
    color: white;
}

.btn-cadastrar {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #6c63ff, #8a7bff);
    color: white;
    font-weight: bold;
    cursor: pointer;
}

.btn-voltar {
    width: 100%;
    margin-top: 10px;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #6c63ff;
    background: transparent;
    color: #6c63ff;
    cursor: pointer;
}
    </style>
</head>

<body>

<div class="container">

    <h1>Cadastro</h1>

    <form action="" method="POST">

        <label>Email</label>
        <input type="email" name="email" placeholder="Digite seu email" required>

        <label>Senha</label>
        <input type="password" name="senha" placeholder="Digite sua senha" required>

        <button type="submit" class="btn-cadastrar">
            Cadastrar
        </button>

    </form>

    <button type="button" class="btn-voltar" onclick="window.location.href='login.php'">
        ir para login
    </button>

</div>

</body>
</html>

<?php

include("conexao.php");

// 🔥 garante que $conn existe
if (!isset($conn)) {
    die("Erro: conexão não encontrada. Verifique o conexao.php");
}

// só executa quando clicar em cadastrar
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // valida email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido!");
    }

    // valida senha forte
    if (
        strlen($senha) < 8 ||
        !preg_match('/[A-Z]/', $senha) ||
        !preg_match('/[a-z]/', $senha) ||
        !preg_match('/[0-9]/', $senha) ||
        !preg_match('/[\W]/', $senha)
    ) {
        die("Senha fraca!");
    }

    // criptografa
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // salva
    $sql = " INSERT INTO cadastro (email, senha) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    
if (!$stmt) {
    die("Erro no prepare: " . $mysqli->error);
}

    $stmt->bind_param("ss", $email, $senhaHash);
    $stmt->execute();

    $conn->close();

    header("Location: login.php");
    exit;
}
?>
