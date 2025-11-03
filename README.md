# Janji
Saya Muhammad 'Azmi Salam dengan NIM 2406010 mengerjakan Tugas Praktikum 7 pada Mata Kuliah Desain dan Pemrograman Berorientasi Objek (DPBO) untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

# 🛠️ Lab Tool Borrowing System (Sistem Peminjaman Alat Lab)

Sistem berbasis PHP sederhana untuk mengelola inventaris alat laboratorium, data pengguna, dan mencatat riwayat peminjaman/pengembalian.

## 🌟 Fitur Utama

Sistem ini menyediakan fungsionalitas CRUD (Create, Read, Update, Delete) lengkap untuk empat entitas utama:

  * **Pengguna (Users):** Mencatat nama, peran (`student`, `assistant`, `admin`), dan kontak.
  * **Tipe Alat (Tool Types):** Mengelola kategori alat (misalnya, *Multimeter*, *Oscilloscope*).
  * **Item Alat (Tool Items):** Mencatat detail setiap unit alat, termasuk tipe, nomor seri, kondisi (`baik`, `rusak`, `hilang`), dan status (`available`, `borrowed`, `unavailable`).
  * **Catatan Peminjaman (Borrow Records):** Mencatat transaksi peminjaman alat oleh pengguna, mencakup waktu pinjam, waktu kembali, dan status (`borrowed`, `returned`).

## 📁 Struktur Proyek

Proyek ini menggunakan arsitektur MVC (Model-View-Controller) yang sederhana, di mana file Class bertindak sebagai Model (logika database) dan file PHP di folder `view/` bertindak sebagai View (tampilan).

```
.
├── class/
│   ├── BorrowRecord.php    # Kelas untuk mengelola data peminjaman
│   ├── ToolItem.php        # Kelas untuk mengelola data item alat
│   ├── ToolType.php        # Kelas untuk mengelola data kategori alat
│   └── User.php            # Kelas untuk mengelola data pengguna
├── config/
│   └── Database.php        # Konfigurasi koneksi database PDO
├── view/
│   ├── borrow_records.php  # Tampilan dan logika CRUD catatan peminjaman
│   ├── tool_items.php
│   ├── tool_types.php
│   └── users.php
├── index.php               # Halaman utama dan navigasi
└── styles.css              # Styling aplikasi
```

## ⚙️ Persyaratan Sistem

Untuk menjalankan aplikasi ini, Anda memerlukan lingkungan server web dengan:

1.  **PHP** (Disarankan versi 7.4 ke atas)
2.  **MySQL** atau **MariaDB**
3.  Server Web (**Apache/Nginx**)
4.  Ekstensi **PDO** untuk koneksi database.

## 🚀 Instalasi dan Setup

### 1\. Konfigurasi Database

Buat database baru (misalnya, `lab_tools_db`) dan jalankan skema SQL berikut untuk membuat tabel yang dibutuhkan:

```sql
-- Skema Database (Estimasi)

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role ENUM('student', 'assistant', 'admin') NOT NULL,
    contact VARCHAR(100)
);

CREATE TABLE tool_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE tool_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tool_type_id INT NOT NULL,
    serial VARCHAR(100) UNIQUE NOT NULL,
    `condition` ENUM('baik', 'rusak', 'hilang') NOT NULL,
    status ENUM('available', 'borrowed', 'unavailable') NOT NULL,
    FOREIGN KEY (tool_type_id) REFERENCES tool_types(id)
);

CREATE TABLE borrow_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tool_item_id INT NOT NULL,
    user_id INT NOT NULL,
    borrowed_at DATETIME NOT NULL,
    returned_at DATETIME NULL,
    status ENUM('borrowed', 'returned') NOT NULL,
    FOREIGN KEY (tool_item_id) REFERENCES tool_items(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### 2\. Update File Koneksi

Pastikan Anda telah mengisi detail koneksi database di file `config/Database.php` Anda (asumsi file ini ada).

### 3\. Jalankan Aplikasi

Setelah file ditempatkan di *root* server web Anda, akses melalui *browser*:

```
http://localhost/nama-folder-proyek/
```

Anda akan diarahkan ke `index.php`, di mana Anda bisa mulai mengelola data melalui menu navigasi.