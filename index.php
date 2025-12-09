<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, orange, rgb(60, 97, 219));
        }

        h1 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }

        .login-container {
            width: 350px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            color: #333;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: rgb(60, 97, 219);
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.3s ease;
        }

        .login-container input[type="submit"]:hover {
            background-color: rgb(45, 75, 180);
        }

        footer {
            text-align: center;
            padding: 15px;
            color: white;
            font-size: 13px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h1>Seja bem-vindo</h1>

    <div class="login-container">
        <form action="login.php" method="post">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

            <input type="submit" value="Entrar">
        </form>
    </div>

    <footer>
        &copy; Trabalho php.
    </footer>

</body>
</html>
