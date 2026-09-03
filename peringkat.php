<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";


// ==========================================
// CEK LOGIN
// ==========================================

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}


// ==========================================
// QUERY PERINGKAT
// ==========================================

$query = mysqli_query(
    $conn,
    "SELECT 
        users.id,
        users.nama,
        MAX(hasil_quiz.skor) AS skor_tertinggi
     FROM hasil_quiz
     INNER JOIN users 
        ON hasil_quiz.user_id = users.id
     GROUP BY users.id, users.nama
     ORDER BY skor_tertinggi DESC, users.nama ASC"
);


// ==========================================
// CEK QUERY
// ==========================================

if (!$query) {

    die(
        "Query peringkat gagal: " .
        mysqli_error($conn)
    );

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Peringkat - TechQuest</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <style>

        body {
            margin: 0;
            background: #f5f8ff;
            font-family: Arial, sans-serif;
        }


        /* NAVBAR */

        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }


        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
        }


        .navbar-brand img {
            width: 55px;
            height: 55px;
            object-fit: contain;
            margin-right: 12px;
        }


        .brand-title {
            color: #0d6efd;
            font-size: 24px;
            font-weight: bold;
        }


        .brand-subtitle {
            color: #222;
            font-size: 15px;
        }


        .nav-link {
            color: #555 !important;
            font-size: 18px;
            margin: 0 10px;
        }


        .nav-link:hover {
            color: #0d6efd !important;
        }


        /* HEADER */

        .peringkat-header {
            text-align: center;
            padding: 55px 20px 30px;
        }


        .peringkat-header h1 {
            font-size: 45px;
            font-weight: bold;
            color: #202124;
        }


        .peringkat-header p {
            color: #555;
            font-size: 19px;
        }


        /* CARD */

        .peringkat-container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }


        .peringkat-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }


        /* TABLE */

        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }


        .table thead th {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 15px;
        }


        .table tbody td {
            padding: 16px;
        }


        .rank {
            font-size: 22px;
            font-weight: bold;
        }


        .nama-user {
            font-weight: 600;
        }


        .skor {
            color: #0d6efd;
            font-size: 20px;
            font-weight: bold;
        }


        @media (max-width: 768px) {

            .peringkat-header h1 {
                font-size: 32px;
            }

            .peringkat-header p {
                font-size: 16px;
            }

        }

    </style>

</head>


<body>


<!-- ==========================================
     NAVBAR
========================================== -->

<nav class="navbar navbar-expand-lg sticky-top">

    <div class="container">


        <!-- LOGO -->

        <a
            class="navbar-brand"
            href="index.php"
        >

            <img
                src="assets/img/logo.png"
                alt="TechQuest"
            >


            <div>

                <div class="brand-title">
                    TechQuest
                </div>

                <div class="brand-subtitle">
                    Teknik Komputer dan Jaringan
                </div>

            </div>

        </a>


        <!-- BUTTON MOBILE -->

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuNavbar"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- MENU -->

        <div
            class="collapse navbar-collapse"
            id="menuNavbar"
        >

            <ul class="navbar-nav mx-auto">


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="index.php"
                    >
                        Beranda
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="quiz/index.php"
                    >
                        Quiz
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="materi/index.php"
                    >
                        Materi
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="peringkat.php"
                    >
                        Peringkat
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="tentang.php"
                    >
                        Tentang
                    </a>

                </li>


                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="kontak.php"
                    >
                        Kontak
                    </a>

                </li>

            </ul>


            <!-- USER -->

            <div class="d-flex align-items-center gap-3">

                <span>

                    Halo,
                    <?php

                    echo htmlspecialchars(
                        $_SESSION['nama'] ?? 'User'
                    );

                    ?>

                </span>


                <a
                    href="auth/logout.php"
                    class="btn btn-danger px-4"
                >
                    Logout
                </a>

            </div>

        </div>

    </div>

</nav>


<!-- ==========================================
     JUDUL
========================================== -->

<div class="peringkat-header">

    <h1>
        🏆 Peringkat Quiz
    </h1>


    <p>
        Lihat peringkat peserta berdasarkan nilai quiz terbaik
    </p>

</div>


<!-- ==========================================
     TABEL
========================================== -->

<div class="peringkat-container">

    <div class="peringkat-card">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th width="150">
                            Peringkat
                        </th>

                        <th>
                            Nama
                        </th>

                        <th width="150">
                            Nilai
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php

                $peringkat = 1;


                if (mysqli_num_rows($query) > 0) {


                    while ($row = mysqli_fetch_assoc($query)) {

                ?>

                    <tr>

                        <td class="rank">

                            <?php

                            if ($peringkat == 1) {

                                echo "🥇";

                            } elseif ($peringkat == 2) {

                                echo "🥈";

                            } elseif ($peringkat == 3) {

                                echo "🥉";

                            } else {

                                echo $peringkat;

                            }

                            ?>

                        </td>


                        <td class="nama-user">

                            <?php

                            echo htmlspecialchars(
                                $row['nama']
                            );

                            ?>

                        </td>


                        <td class="skor">

                            <?php

                            echo htmlspecialchars(
                                $row['skor_tertinggi']
                            );

                            ?>

                        </td>

                    </tr>


                <?php

                        $peringkat++;

                    }


                } else {

                ?>

                    <tr>

                        <td
                            colspan="3"
                            class="text-center"
                        >

                            Belum ada peserta yang
                            menyelesaikan quiz.

                        </td>

                    </tr>

                <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>