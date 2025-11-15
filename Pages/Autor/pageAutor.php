<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <title>Document</title>

</head>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    * {
        box-sizing: border-box
    }

    input[type=text],
    input[type=Name] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus,
    input[type=name]:focus {
        background-color: #ddd;
        outline: none;
    }


    input[type=text],
    input[type=date] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus,
    input[type=date]:focus {
        background-color: #ddd;
        outline: none;
    }


    textarea[name="biografia"] {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Segoe UI', sans-serif;
        resize: vertical;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
    }

    textarea[name="biografia"]:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }

    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    button {
        background-color: #04AA6D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    button:hover {
        opacity: 1;
    }

    .cancelbtn {
        padding: 14px 20px;
        background-color: #f44336;
    }

    .cancelbtn,
    .signupbtn {
        float: left;
        width: 50%;
    }

    .container {
        padding: 16px;
    }


    .clearfix::after {
        content: "";
        clear: both;
        display: table;
    }

    @media screen and (max-width: 600px) {

        .cancelbtn,
        .signupbtn {
            width: 100%;
        }
    }

    h1 {
        text-align: center;
    }

    textarea[name="Biografia"] {
        width: 100%;
        min-height: 120px;
        padding: 14px 18px;
        border: 1px solid #ccc;
        border-radius: 10px;
        font-size: 15px;
        font-family: 'Segoe UI', sans-serif;
        resize: vertical;
        background: #fdfdfd;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    textarea[name="Biografia"]:focus {
        outline: none;
        border-color: #04AA6D;
        background: #fff;
        box-shadow: 0 0 8px rgba(4, 170, 109, 0.3);
    }
</style>

<body>
    <?php
    include("../../dados/conexao/conexao.php");
    include("../../Components/menu/menu.html");


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $Nome = $_POST["Nome"] ?? null;
        $Email = $_POST["Email"] ?? null;
        $DataNascimento = $_POST["DataNascimento"] ?? null;
        $Biografia = $_POST["Biografia"] ?? null;

        if ($Nome && $Email) {
            $sql = "INSERT INTO autor (Nome, Email, DataNascimento, Biografia) VALUES (?, ?, ?, ?)";
            $insert = $conn->prepare($sql);
            $insert->bind_param("ssss", $Nome, $Email, $DataNascimento, $Biografia);

            if ($insert->execute()) {
                header("Location: /Biblioteca-Universo-da-Palavra/Pages/Autor/pageListarAutores.php?sucesso=1");
                exit();
            } else {
                echo "Erro ao inserir registros: " . $conn->error;
            }

            $insert->close();
        } else {
            echo "Erro: Nome e Email são obrigatórios.";
        }

        $conn->close();
    }
    ?>



    <h1>Registro Autor</h1>

    <form action "/Biblioteca-Universo-da-Palavra/Pages/Autor/pageAutor.php" style="border:1px solid #ccc"
        method="POST">


        <div class="container">

            <h1>Inscrição</h1>
            <p>Por favor, preencha este formulário para criar uma conta.</p>
            <hr>


            <label for="Nome"><b>Nome</b></label>
            <input type="text" name="Nome" required>

            <label for="Email"><b>Email</b></label>
            <input type="text" name="Email" required>

            <label for="DataNascimento"><b>Data de Nascimento</b></label>
            <input type="date" name="DataNascimento" required>

            <label for="biografia"><b>Biografia</b></label>
            <textarea name="Biografia"></textarea>

            <p>Ao criar uma conta, você concorda com nossos <a href="#" style="color:dodgerblue">Termos &
                    Privacidade</a>.</p>

            <div class="clearfix">
                <button type="button" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Inscrição</button>
            </div>
        </div>
    </form>
</body>

</html>