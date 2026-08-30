<?php
require_once "../models/User.php";
require_once "../models/Barang.php";
require_once "../helpers/response.php";

class BarangController
{
    private $barang;

    public function __construct($db)
    {
        $this->barang = new Barang($db);
    }

    public function index()
    {
        jsonResponse($this->barang->getAll());
    }

    public function show($id)
    {
        $data = $this->barang->getById($id);
        $data
            ? jsonResponse($data)
            : jsonResponse(["message" => "Barang not found"], 404);
    }

    public function store($data)
    {
        if (!$data['penjual_id'] || !$data['nama_barang'] || !$data['deskripsi'] || !$data['harga'] || !$data['stok'] || !$data['foto']) {
            jsonResponse(["message" => "Invalid data"], 422);
        }

        $this->barang->create(
            $data['penjual_id'],
            $data['nama_barang'],
            $data['deskripsi'],
            $data['harga'],
            $data['stok'],
            $data['foto']
        );

        jsonResponse(["message" => "Barang created"]);
    }

    public function update($id, $data)
    {
        $this->barang->update(
            $id,
            $data['penjual_id'],
            $data['nama_barang'],
            $data['deskripsi'],
            $data['harga'],
            $data['stok'],
            $data['foto']
        );
        jsonResponse(["message" => "Barang updated"]);
    }

    public function destroy($id)
    {
        $this->barang->delete($id);
        jsonResponse(["message" => "Barang deleted"]);
    }
}
