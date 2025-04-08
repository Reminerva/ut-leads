<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$tanggal   = $_POST['tanggal'] ?? '';
$id_sales  = $_POST['id_sales'] ?? '';
$id_produk = $_POST['id_produk'] ?? '';
$no_wa     = $_POST['no_wa'] ?? '';
$nama_lead = $_POST['nama_lead'] ?? '';
$kota      = $_POST['kota'] ?? '';
$id_user   = $_POST['id_user'] ?? '';

if (empty($tanggal) || empty($id_sales) || empty($id_produk) || empty($no_wa) || empty($nama_lead) || empty($kota) || empty($id_user)) {
    die("<div style='color:red;'>Semua field harus diisi!</div>");
}

$stmt = $conn->prepare("INSERT INTO leads (tanggal, id_sales, id_produk, no_wa, nama_lead, kota, id_user) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("siisssi", $tanggal, $id_sales, $id_produk, $no_wa, $nama_lead, $kota, $id_user);

if ($stmt->execute()) {
    echo "<div style='color:green;'>Data berhasil disimpan!</div>";
    echo "<a href='index.php'>Kembali</a>";
} else {
    echo "<div style='color:red;'>Gagal menyimpan data: " . $stmt->error . "</div>";
}

$stmt->close();
$conn->close();
?>
