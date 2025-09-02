<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Acudiente</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #74ebd5, #ACB6E5);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      width: 350px;
      text-align: center;
    }

    .login-box h1 {
      margin-bottom: 20px;
      color: #333;
    }

    .login-box label {
      display: block;
      text-align: left;
      margin: 10px 0 5px;
      font-weight: bold;
      color: #555;
    }

    .login-box input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      transition: border 0.3s;
    }

    .login-box input:focus {
      border-color: #4a90e2;
      outline: none;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background: #4a90e2;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    .login-box button:hover {
      background: #357ABD;
      transform: scale(1.03);
    }

    .login-box p {
      margin-top: 15px;
      font-size: 14px;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h1>Login Acudiente</h1>
    <form action="loguearse_acudiente.php" method="POST">
      <label for="acudiente_correo">Correo electrónico</label>
      <input type="email" name="correo" id="acudiente" required>

      <label for="acudiente_password">Contraseña</label>
      <input type="password" name="password" id="acudiente_password" required>

      <button type="submit">Ingresar</button>
    </form>
    <p>¿Olvidaste tu contraseña? <a href="#">Recupérala aquí</a></p>
  </div>
</body>
</html>