<?php
include_once("./Controllers/client.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>Ejemplo MVC con PHP</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Home</title>
</head>

<body>

    <h1>Página principal Home</h1>
    <p>Nombre página: <?= $data['page_title'] ?> </p>
    <p>
    <h1>Data desde la vista</h1>
    <style>
        td,
        th {
            width: 200px;
            padding: 10px;

        }

        tr {
            border-bottom: 1px solid black;
        }

        .par {
            background-color: gray;
        }

        .impar {
            background-color: aliceblue;
        }

        input {
            display: block;
        }
    </style>
    <?php

    dep($data);
    ?>
    </p>
    <?php
    $ch = curl_init();
    $urlGetClientes = "http://localhost/miguel2556456/Diego(Clase9PHP)/championFramework/client/getAllClients";

    curl_setopt($ch, CURLOPT_URL, $urlGetClientes);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        echo "Error al conectarse a la API getAllClients";
    } else {
        curl_close($ch);
        $responseJson = json_decode($response, associative: true);
        echo "<table>";
    ?>
        <tr>
            <th>Id</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Identificacion</th>
            <th>Direccion</th>
            <th>Nombre_fiscal</th>
            <th>Direccion_fiscal</th>
            <th>Nit</th>
            <th>Status</th>
        </tr>
    <?php

        for ($x = 0; $x < count($responseJson["mensaje"]); $x++) {

            if ($x % 2 == 0) {
                echo "<tr class='par'>";
            } else {
                echo "<tr class='impar'>";
            }
            print_r("<td>" . $responseJson["mensaje"][$x]["id"] . "</td>");
            print_r("<td>" . $responseJson["mensaje"][$x]["nombres"] . "</td>");
            print_r("<td>" . $responseJson["mensaje"][$x]["apellidos"] . "</td>");
            print_r("<td>" . $responseJson["mensaje"][$x]["identificacion"] . "</td>");
            print_r("<td>" . $responseJson["mensaje"][$x]["direccion"] . "</td>");
            print_r("<td>" . $responseJson["mensaje"][$x]["nombre_fiscal"] . "</td>");
            print_r("<td>" . $responseJson["mensaje"][$x]["direccion_fiscal"] . "</td>");
            print_r("<td>" . $responseJson["mensaje"][$x]["nit"] . "</td>");
            print_r("<td>" . $responseJson["mensaje"][$x]["status"] . "</td>");
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
    <form action="" method="POST">
        <label for="">Nombres:</label>
        <input type="text" name="nombres" id="">
        <label for="">Apellidos:</label>
        <input type="text" name="apellidos" id="">
        <label for="">Telefono:</label>
        <input type="text" name="telefono" id="">
        <label for="">Identificacion:</label>
        <input type="text" name="identificacion" id="">
        <label for="">Direccion:</label>
        <input type="text" name="direccion" id="">
        <label for="">Nombre_fiscal:</label>
        <input type="text" name="nombre_fiscal" id="">
        <label for="">Direccion_fiscal:</label>
        <input type="text" name="direccion_fiscal" id="">
        <label for="">Nit:</label>
        <input type="text" name="nit" id="">
        <label for="">Email:</label>
        <input type="text" name="email" id="">
        <input type="submit" value="Registrar" name="registrarCliente">
    </form>
    <?php
    if (isset($_POST["registrarCliente"])) {
        $objCliente = new Client;
        $setCliente = $objCliente->setClient();
        echo $setCliente;
    }
    ?>
</body>

</html>