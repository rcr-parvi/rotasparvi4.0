<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROTA</title>
    <link rel="stylesheet" href="ROTAS.css">
    <script>
        function updateMap(link) {
            document.getElementById('mapFrame').src = link;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="../index.html" class="back-button">Voltar</a>
            <img src="logo parvi.png" alt="Grupo Parvi">
            <h1>TS-02</h1>
        </div>
    </div> 
    <div class="content">
        <div class="map-iframe">
            <iframe id="mapFrame" src="" width="640" height="480"></iframe>
        </div>
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
                        <?php
                        // Conectar ao banco de dados
                        $conn = new mysqli('localhost', 'root', '', 'rotas');

                        // Verificar conexão
                        if ($conn->connect_error) {
                            die("Conexão falhou: " . $conn->connect_error);
                        }

                        // Recuperar dados da tabela TS-01
                        $sql = "SELECT nome, ponto_embarque, horario_07x19, horario_19x07, mapa_link FROM `TS-01`";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Saída de dados para cada linha
                            while($row = $result->fetch_assoc()) {
                                echo "<tr onclick=\"updateMap('" . $row["mapa_link"] . "')\" style=\"cursor: pointer;\">";
                                echo "<td>" . $row["nome"] . "</td>";
                                echo "<td>" . $row["ponto_embarque"] . "</td>";
                                echo "<td>" . $row["horario_07x19"] . "</td>";
                                echo "<td>" . $row["horario_19x07"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Nenhum resultado encontrado</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
