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
