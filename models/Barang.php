<?php

class Barang
{
    private $conn;
    private $table = "barang";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get barang by nama
    public function findByBarang(string $namaBarang): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE nama_barang = :nama_barang LIMIT 1"
        );
        $stmt->execute(["nama_barang" => $namaBarang]);
        $barang = $stmt->fetch();

        return $barang ?: null;
    }

    // CREATE
    public function create($penjualId, $namaBarang, $deskripsi, $harga, $stok, $foto)
    {
        $sql = "INSERT INTO {$this->table} (penjual_id, nama_barang, deskripsi, harga, stok, foto)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$penjualId, $namaBarang, $deskripsi, $harga, $stok, $foto]);
    }

    // READ ALL
    public function getAll()
    {
        $sql = "SELECT id, penjual_id, nama_barang, deskripsi, harga, stok, foto FROM {$this->table}";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ BY ID
    public function getById($id)
    {
        $sql = "SELECT id, penjual_id, nama_barang, deskripsi, harga, stok, foto FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $penjualId, $namaBarang, $deskripsi, $harga, $stok, $foto)
    {
        $sql = "UPDATE {$this->table}
                SET penjual_id = ?, nama_barang = ?, deskripsi = ?, harga = ?, stok = ?, foto = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$penjualId, $namaBarang, $deskripsi, $harga, $stok, $foto, $id]);
    }

    // DELETE
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
