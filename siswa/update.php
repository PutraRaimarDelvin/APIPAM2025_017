<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/../koneksi.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "JSON kosong"]);
    exit;
}

$sql = "UPDATE siswa_magang SET
        nama = ?,
        universitas = ?,
        jurusan_id = ?,
        penempatan_id = ?,
        tanggal_mulai = ?,
        tanggal_selesai = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssiissi",
    $data['nama'],
    $data['universitas'],
    $data['jurusan_id'],
    $data['penempatan_id'],
    $data['tanggal_mulai'],
    $data['tanggal_selesai'],
    $data['id']
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "error" => $stmt->error
    ]);
}
