<?php
$tipo_usuario = $_POST['tipo_usuario'];
if($tipo_usuario == 'paciente') {
    header('Location: paciente/index.php');
} elseif($tipo_usuario == 'nutricionista') {
    header('Location: nutricionista/index.php');
} elseif($tipo_usuario == 'medico') {
    header('Location: medico/index.php');
} else {
    echo "Tipo de usuário inválido.";
}
?>