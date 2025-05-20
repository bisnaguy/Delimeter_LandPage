<?php
    $banco = new PDO('sqlite:database/banco_dados.db');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $senha =password_hash($_POST['senha'],PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (nm_usuario, email_usuario, senha_usuario) VALUES (:name, :email, :senha)";
    $stmt=$banco->prepare($sql);
    $stmt->execute([
        ':name'=>$name,
        ':email'=>$email,
        ':senha'=>$senha
    ]);
        header("Location: entrar_usuario.php");
        exit();
?>