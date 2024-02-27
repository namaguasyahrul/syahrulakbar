<?php
include "koneksi2.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaKategori = $_POST["namaKategori"];

    $query = "INSERT INTO kategoribuku (NamaKategori) VALUES ('$namaKategori')";

    if (mysqli_query($koneksi, $query)) {
        echo "Data berhasil ditambahkan ke database.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>
