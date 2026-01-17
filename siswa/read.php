<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

require_once __DIR__ . "/../koneksi.php";

// PASTIKAN variabel koneksi benar
$koneksi = $koneksi ?? $conn ?? null;

if (!$koneksi) {
    echo json_encode([]);
    exit;
}

$sql = "
    SELECT 
        s.id,
        s.nama,
        s.universitas,
        s.jurusan_id,
        j.nama_jurusan,
        s.penempatan_id,
        p.nama_penempatan,
        s.tanggal_mulai,
        s.tanggal_selesai
    FROM siswa_magang s
    JOIN jurusan j ON s.jurusan_id = j.id
    JOIN penempatan p ON s.penempatan_id = p.id
";

$result = mysqli_query($koneksi, $sql);

$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            "id" => (int)$row["id"],
            "nama" => $row["nama"],
            "universitas" => $row["universitas"],
            "jurusan_id" => (int)$row["jurusan_id"],
            "nama_jurusan" => $row["nama_jurusan"],
            "penempatan_id" => (int)$row["penempatan_id"],
            "nama_penempatan" => $row["nama_penempatan"],
            "tanggal_mulai" => $row["tanggal_mulai"],
            "tanggal_selesai" => $row["tanggal_selesai"]
        ];
    }
}

echo json_encode($data);
