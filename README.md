# Aplikasi Manajemen Leads

Aplikasi ini digunakan untuk menampilkan dan memfilter data leads berdasarkan produk, sales, dan bulan tertentu.

---

## Cara Menjalankan Aplikasi

1. **Clone atau download** project ini.  
2. Jalankan perintah berikut di terminal:
```bash
composer install
```

3. **Rename** file `env_example.txt` menjadi `.env`:

4. **Edit file `.env`** dan sesuaikan dengan kredensial database MySQL anda:
```env
DB_HOST=localhost
DB_USER=root
DB_PASS=your_password
DB_NAME=your_database_name
```

5. Pastikan **database dan tabel `leads`, `produk`, serta `sales`** telah tersedia dan memiliki relasi yang sesuai dengan struktur query pada aplikasi.

6. Jalankan aplikasi menggunakan **web server lokal**:
-  **XAMPP** (akses via `http://localhost/nama-folder-proyek`)


 **Struktur Tabel yang Dibutuhkan**
- `leads(id_leads, tanggal, id_sales, id_produk, nama_lead, no_wa, kota, id_user)`  
- `produk(id_produk, nama_produk)`  
- `sales(id_sales, nama_sales)`
