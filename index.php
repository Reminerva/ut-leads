<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id_produk = $_GET['id_produk'] ?? '';
$id_sales = $_GET['id_sales'] ?? '';
$bulan = $_GET['bulan'] ?? '';

$sql = "SELECT leads.id_leads, leads.tanggal, sales.nama_sales, produk.nama_produk, leads.nama_lead, leads.no_wa, leads.kota
        FROM leads
        JOIN sales ON leads.id_sales = sales.id_sales
        JOIN produk ON leads.id_produk = produk.id_produk
        WHERE 1=1";

if (!empty($id_produk)) {
    $sql .= " AND leads.id_produk = " . intval($id_produk);
}

if (!empty($id_sales)) {
    $sql .= " AND sales.id_sales = " . intval($id_sales);
}

if (!empty($bulan)) {
    $sql .= " AND MONTH(leads.tanggal) = " . intval($bulan);
    $sql .= " AND YEAR(leads.tanggal) = YEAR(CURRENT_DATE())";
}

$sql .= " ORDER BY leads.tanggal DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Leads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Data Leads (Filter Produk, Sales, Bulan)</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="id_produk" class="form-label">Filter Produk:</label>
            <select name="id_produk" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Produk --</option>
                <?php
                $produk_query = $conn->query("SELECT id_produk, nama_produk FROM produk");
                while ($produk = $produk_query->fetch_assoc()) {
                    $selected = $id_produk == $produk['id_produk'] ? 'selected' : '';
                    echo "<option value='{$produk['id_produk']}' $selected>{$produk['nama_produk']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="id_sales" class="form-label">Filter Sales:</label>
            <select name="id_sales" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Sales --</option>
                <?php
                $sales_query = $conn->query("SELECT id_sales, nama_sales FROM sales");
                while ($sales = $sales_query->fetch_assoc()) {
                    $selected = $id_sales == $sales['id_sales'] ? 'selected' : '';
                    echo "<option value='{$sales['id_sales']}' $selected>{$sales['nama_sales']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="bulan" class="form-label">Filter Bulan:</label>
            <select name="bulan" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Bulan --</option>
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $bulanNama = date('F', mktime(0, 0, 0, $i, 10));
                    $selected = $bulan == $i ? 'selected' : '';
                    echo "<option value='$i' $selected>$bulanNama</option>";
                }
                ?>
            </select>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>ID Input</th>
                <th>Tanggal</th>
                <th>Sales</th>
                <th>Produk</th>
                <th>Nama Leads</th>
                <th>No WA</th>
                <th>Kota</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['id_leads']}</td>
                    <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
                    <td>{$row['nama_sales']}</td>
                    <td>{$row['nama_produk']}</td>
                    <td>{$row['nama_lead']}</td>
                    <td>{$row['no_wa']}</td>
                    <td>{$row['kota']}</td>
                </tr>";
                $no++;
            }

            if ($no === 1) {
                echo "<tr><td colspan='8' class='text-center'>Data tidak ditemukan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button class="btn btn-primary" onclick="window.location.href='tambah_leads.php'";>
        Tambah Leads
    </button>
</div>
</body>
</html>
