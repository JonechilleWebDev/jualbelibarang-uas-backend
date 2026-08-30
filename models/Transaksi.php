<?php

class Transaksi
{
    private $conn;
    private $table = "transaksi";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get transaksi by pembeli_id
    public function findByPembeliId(int $pembeliId): ?array
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE pembeli_id = :pembeli_id LIMIT 1"
        );
        $stmt->execute(["pembeli_id" => $pembeliId]);
        $transaksi = $stmt->fetch();

        return $transaksi ?: null;
    }

    // CREATE
    public function create($pembeliId, $barangId, $jumlah, $hargaSatuan, $totalHarga, $status, $catatan)
    {
        $sql = "INSERT INTO {$this->table} (pembeli_id, barang_id, jumlah, harga_satuan, total_harga, status, catatan)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$pembeliId, $barangId, $jumlah, $hargaSatuan, $totalHarga, $status, $catatan]);
    }

    // READ ALL
    public function getAll()
    {
        $sql = "SELECT id, pembeli_id, barang_id, jumlah, harga_satuan, total_harga, status, catatan FROM {$this->table}";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ BY ID
    public function getById($id)
    {
        $sql = "SELECT id, pembeli_id, barang_id, jumlah, harga_satuan, total_harga, status, catatan FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $pembeliId, $barangId, $jumlah, $hargaSatuan, $totalHarga, $status, $catatan)
    {
        $sql = "UPDATE {$this->table}
                SET pembeli_id = ?, barang_id = ?, jumlah = ?, harga_satuan = ?, total_harga = ?, status = ?, catatan = ?
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$pembeliId, $barangId, $jumlah, $hargaSatuan, $totalHarga, $status, $catatan, $id]);
    }

    // DELETE
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
