<?php
require_once "../models/Transaksi.php";
require_once "../helpers/response.php";

class TransaksiController
{
    private $transaksi;

    public function __construct($db)
    {
        $this->transaksi = new Transaksi($db);
    }

    public function index()
    {
        jsonResponse($this->transaksi->getAll());
    }

    public function show($id)
    {
        $data = $this->transaksi->getById($id);
        $data
            ? jsonResponse($data)
            : jsonResponse(["message" => "Transaksi not found"], 404);
    }

    public function store($data)
    {
        if (!$data['pembeli_id'] || !$data['barang_id'] || !$data['jumlah'] || !$data['harga_satuan'] || !$data['total_harga'] || !$data['status'] || !$data['catatan']) {
            jsonResponse(["message" => "Invalid data"], 422);
        }

        $this->transaksi->create(
            $data['pembeli_id'],
            $data['barang_id'],
            $data['jumlah'],
            $data['harga_satuan'],
            $data['total_harga'],
            $data['status'],
            $data['catatan']
        );

        jsonResponse(["message" => "Transaksi created"]);
    }

    public function update($id, $data)
    {
        $this->transaksi->update($id, $data['pembeli_id'], $data['barang_id'], $data['jumlah'], $data['harga_satuan'], $data['total_harga'], $data['status'], $data['catatan']);
        jsonResponse(["message" => "Transaksi updated"]);
    }

    public function destroy($id)
    {
        $this->transaksi->delete($id);
        jsonResponse(["message" => "Transaksi deleted"]);
    }
}
