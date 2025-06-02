<?php
// Configurações de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Caminhos absolutos
define('DB_DIR', __DIR__ . '/database');
define('DB_FILE', DB_DIR . '/database.db');

try {
    // Verifica/Cria o diretório
    if (!file_exists(DB_DIR)) {
        if (!mkdir(DB_DIR, 0755, true)) {
            throw new Exception("Falha ao criar diretório do banco de dados");
        }
    }

    // Conecta ao banco (cria se não existir)
    $db = new SQLite3(DB_FILE);
    
    if (!$db) {
        throw new Exception("Falha ao conectar/criar o banco de dados");
    }

    // Criação da tabela com verificações
    $sql = "CREATE TABLE IF NOT EXISTS usuario (
        id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
        nome_usuario TEXT NOT NULL,
        email_usuario TEXT UNIQUE NOT NULL,
        senha_usuario TEXT NOT NULL,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!$db->exec($sql)) {
        throw new Exception("Erro ao criar tabela: " . $db->lastErrorMsg());
    }

    // Verifica se a tabela foi criada
    $check = $db->querySingle("SELECT name FROM sqlite_master WHERE type='table' AND name='usuario'");
    if (!$check) {
        throw new Exception("Falha na verificação da tabela");
    }

    echo json_encode([
        'status' => true,
        'message' => 'Banco de dados e tabela configurados com sucesso!',
        'db_path' => DB_FILE
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage(),
        'db_path' => DB_FILE
    ]);
}
?>