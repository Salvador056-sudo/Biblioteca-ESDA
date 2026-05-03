<?php
session_start();

// Verificar si el usuario está logueado (por sesión o cookie)
if (!isset($_SESSION['id_usuario'])) {
    if (isset($_COOKIE['id_usuario'])) {
        $_SESSION['id_usuario'] = $_COOKIE["id_usuario"];
    } else {
        header("Location: index.php");
        exit();
    }
}

// Obtener el nombre del usuario desde la base de datos
require_once 'db.php';
$db = conectarDB();

$id_usuario = $_SESSION['id_usuario'];
$sql = "SELECT nombre, email FROM usuarios WHERE id_usuario = :id_usuario";
$query = $db->prepare($sql);
$query->execute(['id_usuario' => $id_usuario]);
$usuario = $query->fetch(PDO::FETCH_ASSOC);

$nombre_usuario = $usuario ? $usuario['nombre'] : 'Usuario';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard - Biblioteca</title>
  <link href="./wwwroot/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./wwwroot/css/bootstrap-icons.min.css">
  <script src="./wwwroot/js/jquery-4.0.0.min.js"></script>
  <style>
    .user-welcome {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border-radius: 10px;
      padding: 10px 20px;
      margin-right: 20px;
    }
    .user-welcome i {
      margin-right: 8px;
    }
  </style>
</head>
<body>

<header>
  <div class="px-3 py-2 text-bg-primary border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
      <h5 class="text-white mb-0">
        <i class="bi bi-book"></i> Sistema Biblioteca
      </h5>
      <div class="d-flex align-items-center">
        <div class="user-welcome text-white">
          <i class="bi bi-person-circle"></i> 
          Hola, <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong>
        </div>
        <a class="text-white btn btn-outline-light btn-sm" href="logout.php">
          <i class="bi bi-box-arrow-right"></i> Salir
        </a>
      </div>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">

    <!-- MENÚ LATERAL -->
    <aside class="col-3 bg-light vh-100 p-3">
      <nav>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="cargar('autor.html'); return false;">
              <i class="bi bi-person"></i> Alta Autor
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#" onclick="cargar('libro.html'); return false;">
              <i class="bi bi-book"></i> Alta Libro
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#" onclick="cargar('prestamo.html'); return false;">
              <i class="bi bi-arrow-left-right"></i> Préstamo
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- CONTENIDO -->
    <main class="col-9 p-4">
      <div id="article">
        <div class="alert alert-info">
          <i class="bi bi-info-circle"></i> Bienvenido, <strong><?php echo htmlspecialchars($nombre_usuario); ?></strong>
          <hr>
          <p class="mb-0">Selecciona una opción del menú para comenzar</p>
        </div>
      </div>
    </main>

  </div>
</div>

<script>
function cargar(pagina) {
  fetch(pagina)
    .then(response => response.text())
    .then(data => {
      document.getElementById('article').innerHTML = data;
    })
    .catch(error => {
      console.error('Error:', error);
      document.getElementById('article').innerHTML = '<div class="alert alert-danger">Error al cargar la página</div>';
    });
}
</script>
<script src="./wwwroot/js/bootstrap.bundle.min.js"></script>
</body>
</html>
