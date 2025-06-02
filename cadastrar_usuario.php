<?php include 'includes/header.php'; ?>
<main>
    <div class="container-calc">
        <form action="insert_server.php" method="POST" id="formulario-cad" onsubmit="return enviarFormulario(event)">
            <div class="container">
                <h1>Cadastro de Usuário</h1>
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" required id="nome">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required id="email">
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" required id="senha">
                </div>
                <button type="submit">Cadastrar</button>
            </div>
        </form>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
