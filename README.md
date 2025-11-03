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
│   ├── User.php            # Kelas untuk mengelola data pengguna
│   │   ├── create()
│   │   ├── readAll()
│   │   ├── getById([ID])
│   │   ├── update()
│   │   └── delete()
│   ├── ToolType.php
│   │   ├── create()
│   │   ├── readAll()
│   │   ├── getById([ID])
│   │   ├── update()
│   │   └── delete()
│   ├── ToolItem.php        # Kelas untuk mengelola data item alat
│   │   ├── create()
│   │   ├── readAll()
│   │   ├── getById([ID])
│   │   ├── update()
│   │   └── delete()
│   └── BorrowRecord.php    # Kelas untuk mengelola data peminjaman
│       ├── create()
│       ├── readAll()
│       ├── getById([ID])
│       ├── update()
│       └── delete()
│
├── config/
│   └── Database.php        # Konfigurasi koneksi database PDO
│
├── view/
│   ├── borrow_records.php
│   ├── tool_items.php
│   ├── tool_types.php
│   └── users.php
│
├── index.php               # Halaman utama dan navigasi
└── styles.css              # Styling aplikasi
```

## Diagram
<img src="Dokumentasi/diagram.png" style="width: 100%;"> 

## Database

```sql
    CREATE DATABASE IF NOT EXISTS lab_loan;
    USE lab_loan;

    -- jenis alat (tool types)
    CREATE TABLE tool_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT
    );

    -- unit fisik alat (each physical item)
    CREATE TABLE tool_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tool_type_id INT NOT NULL,
        serial VARCHAR(100) UNIQUE NOT NULL,
        `condition` ENUM('baik','rusak','hilang') DEFAULT 'baik',
        status ENUM('available','borrowed','unavailable') DEFAULT 'available',
        FOREIGN KEY (tool_type_id) REFERENCES tool_types(id) ON DELETE CASCADE
    );

    -- users tetap sama
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        role ENUM('admin','student','assistant') DEFAULT 'student',
        contact VARCHAR(100)
    );

    -- catatan peminjaman -> merujuk ke tool_items per unit
    CREATE TABLE borrow_records (
        id INT AUTO_INCREMENT PRIMARY KEY,
        tool_item_id INT NOT NULL,
        user_id INT NOT NULL,
        borrowed_at DATETIME NOT NULL,
        returned_at DATETIME NULL,
        status ENUM('borrowed','returned') DEFAULT 'borrowed',
        FOREIGN KEY (tool_item_id) REFERENCES tool_items(id),
        FOREIGN KEY (user_id) REFERENCES users(id)
    );

```

## Dokumentasi
