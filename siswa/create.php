<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/../koneksi.php";

// DEBUG
file_put_contents(__DIR__."/called.txt", "CALLED\n", FILE_APPEND);

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);
file_put_contents(__DIR__."/debug_create.txt", $raw);

if (!$data) {
    echo json_encode(["success" => false, "message" => "JSON kosong"]);
    exit;
}

$nama            = $data["nama"] ?? null;
$universitas     = $data["universitas"] ?? null;
$jurusan_id      = $data["jurusan_id"] ?? null;
$penempatan_id   = $data["penempatan_id"] ?? null;
$tanggal_mulai   = $data["tanggal_mulai"] ?? null;
$tanggal_selesai = $data["tanggal_selesai"] ?? null;

if (
    !$nama || !$universitas || !$jurusan_id ||
    !$penempatan_id || !$tanggal_mulai || !$tanggal_selesai
) {
    echo json_encode([
        "success" => false,
        "message" => "Field tidak lengkap",
        "data" => $data
    ]);
    exit;
}

$sql = "INSERT INTO siswa_magang
        (nama, universitas, jurusan_id, penempatan_id, tanggal_mulai, tanggal_selesai)
        VALUES (?, ?, ?, ?, ?, ?)";


$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssiiss",
    $nama,
    $universitas,
    $jurusan_id,
    $penempatan_id,
    $tanggal_mulai,
    $tanggal_selesai
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode([
        "success" => false,
        "error" => $stmt->error
    ]);
}
