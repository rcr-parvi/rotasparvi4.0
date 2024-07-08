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

// Consulta SQL para recuperar dados da tabela desejada
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);

// Inicializar variáveis para o iframe e dados da tabela
$iframeLink = "";
$dataRows = "";

// Processar os resultados da consulta
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Se não houver um link de iframe definido ainda, pegue o link do primeiro resultado
        if (empty($iframeLink)) {
            $iframeLink = $row["iframe_link"];
        }
        // Construir linhas da tabela
        $dataRows .= "<tr>";
        $dataRows .= "<td>" . $row["bairros"] . "</td>";
        $dataRows .= "<td>" . $row["pontos_de_embarque"] . "</td>";
        $dataRows .= "<td>" . $row["horario_07x19hs"] . "</td>";
        $dataRows .= "<td>" . $row["horario_19x07hs"] . "</td>";
        $dataRows .= "</tr>";
    }
} else {
    $dataRows = "<tr><td colspan='4'>Nenhum dado encontrado</td></tr>";
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
                <iframe src="<?php echo $iframeLink; ?>" width="640" height="480"></iframe>
            </div>
            <!-- Exibir tabela com dados do banco de dados -->
            <div class="table-container">
                <div class="table-box">
                    <table>
                        <thead>
                            <tr>
                                <th>BAIRROS</th>
                                <th>PONTOS DE EMBARQUE</th>
                                <th>07x19hs</th>
                                <th>19x07hs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $dataRows; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Fechar conexão
    $conn->close();
    ?>
</body>
</html>
