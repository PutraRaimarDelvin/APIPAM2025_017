<?php
include __DIR__ . "/../koneksi.php";

$result = $conn->query("SELECT * FROM jurusan");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
