<?php
// Detalhes da conexão com o banco de dados
$servername = "localhost"; // Normalmente "localhost" ou endereço do servidor MySQL
$username = "root";        // Nome de usuário do banco de dados
$password = "";            // Senha do banco de dados
$dbname = "nome_do_banco"; // Nome do banco de dados

// Nome da tabela, baseado no parâmetro de consulta 'table'
$table = isset($_GET['table']) ? $_GET['table'] : 'TS_01';

// Verificar se o nome da tabela é válido
$allowed_tables = ['TS_01', 'TS_02', 'TS_03', 'TS_04', 'TS_05', 'TS_06', 'TS_07', 'TS_08', 'TS_09', 'TS_10', 'TS_11'];
if (!in_array($table, $allowed_tables)) {
    die("Tabela não permitida.");
}

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta SQL para recuperar o link do iframe da tabela desejada
$sql = "SELECT iframe_link FROM $table LIMIT 1";
$result = $conn->query($sql);

// Inicializar variável para o link do iframe
$iframeLink = "";

// Processar o resultado da consulta
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $iframeLink = $row["iframe_link"];
} else {
    die("Nenhum link de iframe encontrado na tabela $table.");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROTA</title>
    <link rel="stylesheet" href="ROTAS.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="../index.html" class="back-button">Voltar</a>
            <img src="logo parvi.png" alt="Grupo Parvi">
            <h1>ROTA AQUI</h1>
        </div>
        <div class="content">
            <!-- Exibir iframe recuperado do banco de dados -->
            <div class="map-iframe">
                <iframe src="<?php echo $iframeLink; ?>" width="640" height="480" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>

    <?php
    // Fechar conexão
    $conn->close();
    ?>
</body>
</html>
