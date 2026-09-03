<?php
require "../auth/middleware.php";

requireRole(['admin', 'penjual', 'pembeli']);

jsonResponse([
    "message" => "Selamat datang di Sistem Jual Beli Barang.",
    "user_id" => $currentUser['uid']
]);
