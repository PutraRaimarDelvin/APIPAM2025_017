<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

require_once __DIR__ . "/../koneksi.php";

// pastikan koneksi tersedia
$koneksi = $koneksi ?? $conn ?? null;
if (!$koneksi) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, nama_penempatan FROM penempatan";
$result = mysqli_query($koneksi, $sql);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "id" => (int)$row["id"],
            "nama_penempatan" => $row["nama_penempatan"]
        ];
    }
}

echo json_encode($data);
