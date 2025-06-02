<?php
// Ativar relatório de erros para desenvolvimento
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Iniciar buffer de saída
ob_start();

// Definir cabeçalho JSON
header('Content-Type: application/json');

// Caminho absoluto para o arquivo de banco de dados
define('DB_PATH', __DIR__ . '/database/database.db');

// Resposta padrão
$response = [
    'status' => false,
    'msg' => 'Erro desconhecido',
    'errors' => []
];

try {
    // Verificar método da requisição
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método não permitido. Use POST.");
    }

    // Verificar se o banco de dados existe
    if (!file_exists(DB_PATH)) {
        throw new Exception("Arquivo do banco de dados não encontrado.");
    }

    // Conectar ao banco de dados SQLite
    $banco = new PDO('sqlite:' . DB_PATH);
    $banco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se a tabela existe
    $stmt = $banco->query("SELECT name FROM sqlite_master WHERE type='table' AND name='usuario'");
    if (!$stmt->fetch()) {
        throw new Exception("Tabela 'usuario' não existe.");
    }

    // Obter dados do POST
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Validações
    $errors = [];

    if (empty($nome)) {
        $errors['nome'] = "Nome é obrigatório";
    }

    if (empty($email)) {
        $errors['email'] = "Email é obrigatório";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email inválido";
    }

    if (empty($senha)) {
        $errors['senha'] = "Senha é obrigatória";
    } elseif (strlen($senha) < 6) {
        $errors['senha'] = "Senha deve ter pelo menos 6 caracteres";
    }

    // Verificar se email já existe
    if (empty($errors)) {
        $stmt = $banco->prepare("SELECT id_usuario FROM usuario WHERE email_usuario = ? LIMIT 1");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = "Email já cadastrado";
        }
    }

    // Se houver erros, retornar
    if (!empty($errors)) {
        $response['errors'] = $errors;
        $response['msg'] = "Erros de validação";
        ob_end_clean();
        echo json_encode($response);
        exit;
    }

    // Criar hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir no banco de dados
    $stmt = $banco->prepare("INSERT INTO usuario (nome_usuario, email_usuario, senha_usuario) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$nome, $email, $senhaHash])) {
        $response['status'] = true;
        $response['msg'] = "Usuário cadastrado com sucesso!";
    } else {
        throw new Exception("Falha ao inserir usuário no banco de dados");
    }

} catch(PDOException $e) {
    $response['msg'] = "Erro no banco de dados: " . $e->getMessage();
    error_log("PDO Error: " . $e->getMessage());
} catch(Exception $e) {
    $response['msg'] = "Erro: " . $e->getMessage();
    error_log("Error: " . $e->getMessage());
}

// Enviar resposta
ob_end_clean();
echo json_encode($response);
exit;
?>