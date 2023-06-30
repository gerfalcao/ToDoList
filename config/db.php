<?php 

// Estabelecer a conexão PDO com banco de Dados

require_once 'config.php';

try {
  $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
  $pdo = new PDO($dsn, DB_USER, DB_PASS);
  // Configuração adicional, se necessário
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS tasks (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    concluida TINYINT(1) NOT NULL DEFAULT 0,
    file VARCHAR(255)
    )");
    $stmt->execute();

} catch (PDOException $e) {
  var_dump("Erro de conexão: " . $e->getMessage());
}

?>