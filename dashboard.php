<?php
include 'config.php';

// Query para selecionar todas as viaturas cadastradas
$sql = "SELECT * FROM controle_viatura";
$result = $conn->query($sql);
$viaturas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $viaturas[] = $row;
    }
} else {
    echo "Nenhum registro encontrado";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Saída de Viaturas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #4b5320; /* Verde Oliva */
            color: #fff;
            padding: 10px;
            margin: 0;
            text-align: center;
        }
        label {
            margin-top: 20px;
            display: block;
            text-align: center;
        }
        input[type="date"] {
            padding: 5px;
            margin: 10px auto;
            display: block;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #4b5320; /* Verde Oliva */
            text-align: center;
        }
        th {
            background-color: #4b5320; /* Verde Oliva */
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .viatura-row {
            transition: all 0.3s ease;
        }
        .hidden {
            display: none;
        }
        form {
            display: inline;
        }
        input[type="submit"] {
            padding: 5px 10px;
            background-color: #4b5320; /* Verde Oliva */
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #5e6832; /* Verde Oliva mais escuro */
        }
        .insert-button {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            background-color: #4b5320; /* Verde Oliva */
            color: #fff;
            border: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .insert-button:hover {
            background-color: #5e6832; /* Verde Oliva mais escuro */
        }
    </style>
    <script>
        function filterByDate() {
            var selectedDate = document.getElementById('datePicker').value;
            var rows = document.querySelectorAll('.viatura-row');
            rows.forEach(function(row) {
                if (row.getAttribute('data-date') === selectedDate) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
            var message = document.getElementById('noRecordsMessage');
            message.style.display = 'none';
            if (document.querySelectorAll('.viatura-row:not(.hidden)').length === 0) {
                message.style.display = 'block';
            }
        }
    </script>
</head>
<body>
    <h1>Controle de Saída de Viaturas</h1>
    <a href="inserir_viatura.php" class="insert-button">Inserir Saída de Viatura</a>
    <label for="datePicker">Escolha a data:</label>
    <input type="date" id="datePicker" onchange="filterByDate()">
    <table>
        <tr>
            <th>Data</th>
            <th>Horário de Saída</th>
            <th>Tipo Viatura</th>
            <th>OM</th>
            <th>Motorista</th>
            <th>Chefe Viatura</th>
            <th>Destino</th>
            <th>Horário de Retorno</th>
            <th>KM Rodados</th>
            <th>Abastecimento</th>
            <th>Ação</th>
        </tr>
        <?php foreach ($viaturas as $viatura) { ?>
            <tr class="viatura-row" data-date="<?php echo $viatura['data']; ?>">
                <td><?php echo date('d-m-Y', strtotime($viatura["data"])); ?></td>
                <td><?php echo $viatura["horario"]; ?></td>
                <td><?php echo $viatura["tipo_viatura"]; ?></td>
                <td><?php echo $viatura["om"]; ?></td>
                <td><?php echo $viatura["motorista"]; ?></td>
                <td><?php echo $viatura["chefe_viatura"]; ?></td>
                <td><?php echo $viatura["destino"]; ?></td>
                <td><?php echo $viatura["retorno"]; ?></td>
                <td><?php echo $viatura["km_rodados"]; ?></td>
                <td><?php echo $viatura["abastecimento"]; ?></td>
                <td>
                    <form action="editar_viatura.php" method="GET">
                        <input type="hidden" name="id" value="<?php echo $viatura['id']; ?>">
                        <input type="submit" value="Editar">
                    </form>
                    <form action="excluir_viatura.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este registro?');">
                        <input type="hidden" name="id" value="<?php echo $viatura['id']; ?>">
                        <input type="submit" value="Excluir">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <p id="noRecordsMessage" style="display: none; text-align: center; color: red;">Não há registros nesta data.</p>
</body>
</html>
