<?php

// Conecta-se ao banco de dados
$db = new SQLite3('database.db');

// Define a estrutura da tabela
$sql = "CREATE TABLE usuario (
    id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
    nome_usuario TEXT,
    email_usuario TEXT UNIQUE,
    senha_usuario TEXT
);";

// Executa a consulta para criar a tabela
$result = $db->exec($sql);

// Verifica se a consulta foi executada com sucesso
if ($result) {
    echo "Tabela 'usuarios' criada com sucesso!\n";
} else {
    echo "Erro ao criar a tabela: " . $db->lastErrorMsg() . "\n";
}

// Fecha a conexão com o banco de dados (opcional, mas recomendado)
?>