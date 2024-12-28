<?php
header('Content-Type: application/json');

// Incluye el archivo de conexión a la base de datos
include 'db.php';

// Verifica si la conexión existe
if (!isset($conn)) {
    echo json_encode(['error' => 'La conexión a la base de datos no está definida']);
    exit;
}

// CRUD para Pastel

// Obtener todos los pasteles
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pasteles'])) {
    $stmt = $conn->query("SELECT * FROM Pastel");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Insertar un pastel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['pasteles'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (strtotime($data['Fecha_creacion']) >= strtotime($data['Fecha_vencimiento'])) {
        echo json_encode(['error' => 'La fecha de vencimiento debe ser posterior a la fecha de creación']);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO Pastel (Nombre, Descripcion, Preparado_por, Fecha_creacion, Fecha_vencimiento, Estado) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['Nombre'],
        $data['Descripcion'],
        $data['Preparado_por'],
        $data['Fecha_creacion'],
        $data['Fecha_vencimiento'],
        $data['Estado']
    ]);
    echo json_encode(['id' => $conn->lastInsertId()]);
}

// Editar un pastel
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['pasteles'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("UPDATE Pastel SET Nombre = ?, Descripcion = ?, Preparado_por = ?, Fecha_creacion = ?, Fecha_vencimiento = ?, Estado = ? WHERE id = ?");
    $stmt->execute([
        $data['Nombre'],
        $data['Descripcion'],
        $data['Preparado_por'],
        $data['Fecha_creacion'],
        $data['Fecha_vencimiento'],
        $data['Estado'],
        $data['id']
    ]);
    echo json_encode(['status' => 'success']);
}

// Eliminar un pastel
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['pasteles'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM Pastel WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
}

// CRUD para Ingrediente

// Obtener todos los ingredientes
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['ingredientes'])) {
    $stmt = $conn->query("SELECT * FROM Ingrediente");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Insertar un ingrediente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['ingredientes'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    if (strtotime($data['fecha_ingreso']) >= strtotime($data['fecha_vencimiento'])) {
        echo json_encode(['error' => 'La fecha de vencimiento debe ser posterior a la fecha de ingreso']);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO Ingrediente (nombre, descripcion, fecha_ingreso, fecha_vencimiento, inventario) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['nombre'],
        $data['descripcion'],
        $data['fecha_ingreso'],
        $data['fecha_vencimiento'],
        $data['inventario']
    ]);
    echo json_encode(['id' => $conn->lastInsertId()]);
}

// Editar un ingrediente
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['ingredientes'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("UPDATE Ingrediente SET nombre = ?, descripcion = ?, fecha_ingreso = ?, fecha_vencimiento = ?, inventario = ? WHERE id = ?");
    $stmt->execute([
        $data['nombre'],
        $data['descripcion'],
        $data['fecha_ingreso'],
        $data['fecha_vencimiento'],
        $data['inventario'],
        $data['id']
    ]);
    echo json_encode(['status' => 'success']);
}

// Eliminar un ingrediente
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['ingredientes'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM Ingrediente WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
}

// CRUD para Pastel_ingredientes

// Obtener todos los registros de pastel_ingredientes
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pastel_ingredientes'])) {
    $stmt = $conn->query("SELECT * FROM Pastel_ingredientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// Insertar un registro de relación entre pastel e ingrediente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['pastel_ingredientes'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("INSERT INTO Pastel_ingredientes (id_pastel, id_ingrediente, cantidad_usada) VALUES (?, ?, ?)");
    $stmt->execute([
        $data['id_pastel'],
        $data['id_ingrediente'],
        $data['cantidad_usada']
    ]);
    echo json_encode(['id' => $conn->lastInsertId()]);
}

// Editar un registro de relación entre pastel e ingrediente
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['pastel_ingredientes'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("UPDATE Pastel_ingredientes SET id_pastel = ?, id_ingrediente = ?, cantidad_usada = ? WHERE id = ?");
    $stmt->execute([
        $data['id_pastel'],
        $data['id_ingrediente'],
        $data['cantidad_usada'],
        $data['id']
    ]);
    echo json_encode(['status' => 'success']);
}

// Eliminar un registro de relación entre pastel e ingrediente
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['pastel_ingredientes'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM Pastel_ingredientes WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
}
?>