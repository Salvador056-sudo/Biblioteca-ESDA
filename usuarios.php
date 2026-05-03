<?php

// Sesionecs
session_start();

$_SESSION["username"] = "alopez";
$_SESSION["login_time"] = time();

// index.php
require_once 'db.php'; // Traemos el código del otro archivo

//require_once 'db-pgsql.php'; // Traemos el código del otro archivo


//  Obtenemos los datos del formulario
     $nombre = $_POST['nombre'];
     $email  = $_POST['email'];
     $pwd = $_POST['pwd'];
     // Llamamos a la función y guardamos el objeto en $db
     $db = conectarDB();
      

  try {
        //  Preparamos la consulta con "marcadores" (:nombre, :email)
        // Esto separa la estructura de la consulta de los datos reales
        $sql = "INSERT INTO usuarios (nombre, email,password) VALUES (:nombre, :email, :password)";
        $query = $db->prepare($sql);

	$passwordHash = password_hash($pwd, PASSWORD_DEFAULT);

        // Ejecutamos pasando los datos en un array
        $resultado = $query->execute([
            'nombre' => $nombre,
            'email'  => $email,
	    'password' => $passwordHash
        ]);

       

    if ($resultado) {
        // ✅ CORRECCIÓN 1: Redirigir a index.php, no index.html
        header("Location: index.php");
        exit(); // ✅ IMPORTANTE: Detener la ejecución después de redirigir
    }

} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) {
        // ✅ CORRECCIÓN 2: Redirigir con mensaje de error
        header("Location: registro.html?error=email_existe");
        exit();
    } else {
        echo "Database Error: " . $e->getMessage();
    }
}
?>	
