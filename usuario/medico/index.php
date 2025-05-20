<?php include 'header.php'; ?>
<main>
    <div class="container-calc">
        <form action="user_tipo.php" method="POST" id="formulario">
            <div class="container">
                <h1>Entrar como:</h1>
                <div class="form-group">
                    <label for="tipo_usuario">Nome:</label>
                    <select>
                        <option value="paciente">Paciente</option>
                        <option value="nutricionista">Nutricionista</option>
                        <option value="medico">Médico</option>
                    </select>
                </div>
                <button value="submit" onclick="if (validarFormulario()) enviarDados();">Entrar</button>
            </div>
        </form>
    </div>
</main>
<?php include 'footer.php'; ?>