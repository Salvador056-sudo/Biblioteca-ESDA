<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
  if (isset($_COOKIE['id_usuario'])) {
    $_SESSION['id_usuario'] = $_COOKIE["id_usuario"];
  } else {
    header("Location: index.php");
    exit();
  }
}

// Obtener datos del usuario (ajusta según tu tabla de usuarios)
$nombre_usuario = ''; // Inicializar variable
if (isset($_SESSION['id_usuario'])) {
    // Conexión a BD (asegúrate de tener tu conexión incluida)
    // include 'conexion.php'; // Si tienes archivo de conexión
    
    // O si ya tienes la conexión en este archivo, asegúrate de tenerla
    // Ejemplo genérico (ajusta según tu estructura)
    /*
    $sql = "SELECT nombre FROM usuarios WHERE id = " . $_SESSION['id_usuario'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_usuario = $row['nombre'];
    }
    */
    
    // Si solo tienes guardado el nombre en sesión, usa:
    if (isset($_SESSION['nombre_usuario'])) {
        $nombre_usuario = $_SESSION['nombre_usuario'];
    } else {
        // Si no tienes el nombre en sesión, usa solo el ID
        $nombre_usuario = "Usuario ID: " . $_SESSION['id_usuario'];
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link href="./wwwroot/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./wwwroot/css/bootstrap-icons.min.css">
  <script src="./wwwroot/js/jquery-4.0.0.min.js"></script>
  <script src="./wwwroot/js/script.js"></script>
</head>

<body>

<header>
  <div class="px-3 py-2 text-bg-primary border-bottom">
    <div class="container d-flex justify-content-between">
      <h5 class="text-white">Sistema Biblioteca</h5>
      <div>
        <span class="text-white me-3">Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></span>
        <a class="text-white" href="logout.php">Salir</a>
      </div>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">

    <!-- MENÚ -->
    <aside class="col-3 bg-light vh-100 p-3">
      <nav>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="cargar('autor.html')">
              <i class="bi bi-person"></i> Alta Autor
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#" onclick="cargar('libro.html')">
              <i class="bi bi-book"></i> Alta Libro
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#" onclick="cargar('prestamo.html')">
              <i class="bi bi-arrow-left-right"></i> Préstamo
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- CONTENIDO -->
    <main class="col-9 p-4">
      <div id="article">
        <h4>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?></h4>
        <p>Selecciona una opción del menú</p>
      </div>
    </main>

  </div>
</div>

<script src="./wwwroot/js/bootstrap.bundle.min.js"></script>
</body>
</html>
