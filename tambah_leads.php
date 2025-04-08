<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Leads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h3 class="mb-4 text-center">Selamat Datang di Tambah Leads</h3>
            
            <form action="simpan.php" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" required>
                    </div>
                    <div class="col-md-6">
                        <label for="id_sales" class="form-label">Sales</label>
                        <select class="form-select" name="id_sales" required>
                            <option value="">-- Pilih Sales --</option>
                            <?php
                            require_once __DIR__ . '/vendor/autoload.php';

                            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
                            $dotenv->load();
                            
                            $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
                            
                            if ($conn->connect_error) {
                                die("Koneksi gagal: " . $conn->connect_error);
                            }

                            $sql = "SELECT * FROM sales";
                            $result = $conn->query($sql);

                            $data_sales = $result->fetch_all(MYSQLI_ASSOC);

                            foreach ($data_sales as $row) {
                                echo "<option value='".htmlspecialchars($row['id_sales'], ENT_QUOTES)."'>"
                                    .htmlspecialchars($row['nama_sales'], ENT_QUOTES)."</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="id_produk" class="form-label">Produk</label>
                        <select class="form-select" name="id_produk" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php
                            
                            $result_produk = $conn->query("SELECT * FROM produk");
                            
                            if (!$result_produk) {
                                die("Query error: " . $conn->error);
                            }
                            
                            if ($result_produk->num_rows > 0) {
                                while ($row = $result_produk->fetch_assoc()) {
                                    echo "<option value='".htmlspecialchars($row['id_produk'], ENT_QUOTES)."'>"
                                        .htmlspecialchars($row['nama_produk'], ENT_QUOTES)."</option>";
                                }
                            } else {
                                echo "<option disabled>Tidak ada produk</option>";
                            }
                            
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="no_wa" class="form-label">No. Whatsapp</label>
                        <input type="text" class="form-control" name="no_wa" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_lead" class="form-label">Nama Lead</label>
                        <input type="text" class="form-control" name="nama_lead" required>
                    </div>
                    <div class="col-md-6">
                        <label for="kota" class="form-label">Nama Kota</label>
                        <input type="text" class="form-control" name="kota" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="id_user" class="form-label">Id User</label>
                        <input type="text" class="form-control" name="id_user" required>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary me-md-2">Simpan</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>