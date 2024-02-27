<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Ulasan Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            font-family: arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #20c997;
            color: white;
            border: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0d6efd;
            color: white;
        }
        .return-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .return-btn.returned {
            background-color: #3498db;
            color: white;
        }
        .return-btn.not-returned {
            background-color: #e74c3c;
            color: white;
        }
        .delete-btn {
            padding: 8px 12px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .menu-btn {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="content mt-3">
            <div class="card bg-primary bg-gradient">
                <div class="card-body">
                    <a href="http://localhost/digitallibrary/admin/" class="btn btn-light text-dark">HOME</a>
                    <a href="http://localhost/digitallibrary/admin/kategoribuku.php" class="btn btn-light text-dark">KATEGORI BUKU</a>
                    <a href="http://localhost/digitallibrary/admin/tampil_buku.php" class="btn btn-light text-dark">BUKU</a>
                    <a href="http://localhost/digitallibrary/admin/user/tampil_user.php" class="btn btn-light text-dark">USERS</a>
                    <a href="http://localhost/digitallibrary/peminjam/form_peminjaman.php/" class="btn btn-light text-dark">PEMINJAMAN</a>
                    <a href="http://localhost/digitallibrary/peminjam/laporanpeminjam.php" class="btn btn-light text-dark">LAPORAN PEMINJAMAN</a>
                    <a href="http://localhost/digitallibrary/admin/ulasanbuku.php" class ="btn btn-light text-dark">ULASAN</a>
                    <a href="http://localhost/digitallibrary/index.php?pesan=info_logout/logout.php" class="btn btn-warning text-light">LOGOUT</a>
                </div>
            </div>
        </div>
        <div class="container">
            <h2>Form Ulasan Buku</h2>
            <!-- Form Peminjaman -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              

                <label for="UserID">UserID:</label>
                <input type="text" id="UserID" name="UserID" required>

                <label for="BukuID">BukuID:</label>
                <select id="BukuID" name="BukuID" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php
                    // Koneksi ke database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "digitallibrary";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    // Ambil data buku dari tabel buku
                    $query = "SELECT BukuID, Judul FROM buku";
                    $result = $conn->query($query);

                    // Tampilkan opsi select berdasarkan data buku
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["BukuID"] . "'>" . $row["BukuID"] . " - " . $row["Judul"] . "</option>";
                        }
                    }

                    // Tutup koneksi
                    $conn->close();
                    ?>
                </select>

                <label for="Ulasan">Ulasan:</label>
                <input type="text" id="Ulasan" name="Ulasan" required>

                <label for="Rating">Rating:</label>
                <input type="text" id="Rating" name="Rating" required>

                <input type="submit" value="Submit">
            </form>

            <?php
            // Koneksi ke database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "digitallibrary";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Koneksi gagal: " . $conn->connect_error);
            }

            // Jika formulir disubmit
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $userID = $_POST['UserID'];
                $bukuID = $_POST['BukuID'];
                $ulasan = $_POST['Ulasan'];
                $rating = $_POST['Rating'];
                
                $sql = "INSERT INTO ulasanbuku (UserID, BukuID, Ulasan, Rating, StatusPengembalian)
                        VALUES ('$userID', '$bukuID', '$ulasan', '$rating', 'Belum Dikembalikan')";

                if ($conn->query($sql) === TRUE) {
                    echo "<p>Data ulasan berhasil disimpan.</p>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Menampilkan data peminjaman dalam tabel
            $sql = "SELECT * FROM ulasanbuku";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Data Ulasan</h2>";
                echo "<table>";
                echo "<tr><th>UlasanID</th><th>UserID</th><th>BukuID</th><th>Ulasan</th><th>Rating</th><th>Action</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["UlasanID"]."</td><td>".$row["UserID"]."</td><td>".$row["BukuID"]."</td><td>".$row["Ulasan"]."</td><td>".$row["Rating"]."</td><td>";
                     {
                  
                    } 
                    echo "<button class='delete-btn' onclick='deleteRecord(".$row["UlasanID"].")'>Hapus</button>";
                    echo "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Tidak ada data Ulasan.</p>";
            }

            // Proses untuk menandai buku sebagai sudah dikembalikan
            if(isset($_GET['return_id'])) {
                $returnID = $_GET['return_id'];
                $updateSql = "UPDATE ulasanbuku SET StatusPengembalian = 'Sudah Dikembalikan' WHERE UlasanID = $returnID";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<p>Status pengembalian berhasil diperbarui.</p>";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            }

            // Proses untuk menghapus entri peminjaman
            if(isset($_GET['delete_id'])) {
                $deleteID = $_GET['delete_id'];
                $deleteSql = "DELETE FROM ulasanbuku WHERE UlasanID = $deleteID";
                if ($conn->query($deleteSql) === TRUE) {
                    echo "<p>Entri berhasil dihapus.</p>";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            }

            $conn->close();
            ?>

            <!-- Script JavaScript -->
            <script>
                function returnBook(ulasanID) {
                    if (confirm("Apakah buku ini sudah dikembalikan?")) {
                        // Kirim request AJAX untuk menandai buku sebagai sudah dikembalikan
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                location.reload(); // Perbarui halaman setelah buku ditandai sebagai sudah dikembalikan
                            }
                        };
                        xhttp.open("GET", "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?return_id=" + ulasanID, true);
                        xhttp.send();
                    }
                }

                function deleteRecord(ulasanID) {
                    if (confirm("Apakah Anda yakin ingin menghapus entri ini?")) {
                        // Kirim request AJAX untuk menghapus entri peminjaman
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                location.reload(); // Perbarui halaman setelah entri dihapus
                            }
                        };
                        xhttp.open("GET", "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?delete_id=" + ulasanID, true);
                        xhttp.send();
                    }
                }
            </script>

        <style>
            body {
                font-family: 'arial', sans-serif;
                background-color: #0d6efd;
                margin: 0;
                padding: 20px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
        </style>
            <button class="menu-btn" onclick="window.location.href='http://localhost/digitallibrary/admin/index.php'">Kembali ke Menu</button>
        </div>
    </div>
</body>
</html>
