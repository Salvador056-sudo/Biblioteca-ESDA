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

// Incluir la conexión a la BD
require_once 'db.php';

// Obtener el nombre del usuario desde la BD
$nombre_usuario = '';
if (isset($_SESSION['id_usuario'])) {
    try {
        $conn = conectarDB();
        $id = $_SESSION['id_usuario'];
        
        // Ajusta "usuarios" y "nombre" según tu tabla
        $sql = "SELECT nombre FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        if ($row = $stmt->fetch()) {
            $nombre_usuario = $row['nombre'];
        } else {
            $nombre_usuario = "Usuario ID: " . $id;
        }
    } catch (PDOException $e) {
        $nombre_usuario = "Error al obtener usuario";
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
