<!DOCTYPE html>
<html lang="es">
<head>
        <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Servicio Social - Inicio de Sesión</title>
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

    .login-container {
      background: white;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      text-align: center;
      width: 400px;
    }

    .login-container h1 {
      margin-bottom: 10px;
      color: #333;
    }

    .login-container h3 {
      margin-bottom: 30px;
      color: #666;
    }

    .role-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      margin: 12px auto;
      padding: 12px;
      width: 100%;
      font-size: 16px;
      font-weight: bold;
      color: white;
      background: #4a90e2;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
      text-decoration: none;
    }

    .role-btn img {
      width: 30px;
      height: 30px;
    }

    .role-btn:hover {
      background: #357ABD;
      transform: scale(1.05);
    }
    
    .home-btn {
      width: 60%;             
      background: #27ae60;     
    }

    .home-btn:hover {
      background: #1e8449;    
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h1>Bienvenido a Servicio Social</h1>
    <h3>Inicio de Sesión</h3>

    <a href="login_admin.php" class="role-btn">
      <img src="img/admin.png" alt="Admin"> Administrador
    </a>

    <a href="login_acudiente.php" class="role-btn">
      <img src="img/acudiente.png" alt="Acudiente"> Acudiente
    </a>

    <a href="login_estudiante.php" class="role-btn">
      <img src="img/estudiante.png" alt="Estudiante"> Estudiante
    </a>

    <a href="login_supervisor.php" class="role-btn">
      <img src="img/supervisor.png" alt="Supervisor"> Supervisor
    </a>

    <h3>
      <a href="index.php" class="role-btn home-btn">
        <img src="img/home.png" alt="Inicio"> Inicio
      </a>
    </h3>
  </div>

</body>
</html>
