<?php
include __DIR__ . "/../koneksi.php";

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM siswa_magang WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(400);
    echo json_encode(["success" => false]);
}
