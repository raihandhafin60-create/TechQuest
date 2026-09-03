<?php
// ==========================================
// KONFIGURASI AWAL
// ==========================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==========================================
// CEK LOGIN
// ==========================================

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

// ==========================================
// AMBIL NAMA USER
// ==========================================

$namaUser = isset($_SESSION['nama'])
    ? $_SESSION['nama']
    : 'Pengguna';
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Kontak - TechQuest</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f8ff;
            font-family: Arial, sans-serif;
            color: #172033;
        }

        /* ==========================================
           HEADER
        ========================================== */

        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 700;
            color: #0d6efd;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 16px;
            color: #222;
        }

        .nav-link {
            font-size: 18px;
            color: #333 !important;
            margin: 0 8px;
            transition: 0.2s;
        }

        .nav-link:hover {
            color: #0d6efd !important;
        }

        .user-name {
            font-size: 18px;
            color: #333;
        }

        .btn-logout {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 16px;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #bb2d3b;
            color: white;
        }

        /* ==========================================
           HERO
        ========================================== */

        .hero {
            text-align: center;
            padding: 70px 20px 40px;
        }

        .hero-icon {
            font-size: 60px;
            margin-bottom: 10px;
        }

        .hero h1 {
            font-size: 52px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 21px;
            color: #555;
            margin: 0;
        }

        /* ==========================================
           CONTAINER
        ========================================== */

        .content-container {
            max-width: 1050px;
            margin: 20px auto 80px;
            padding: 0 20px;
        }

        /* ==========================================
           CARD PROFIL
        ========================================== */

        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .profile-title {
            text-align: center;
            margin-bottom: 35px;
        }

        .profile-title h2 {
            color: #0d6efd;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .profile-title p {
            color: #666;
            font-size: 18px;
        }

        /* ==========================================
           INFO
        ========================================== */

        .info-box {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 14px;
            border-left: 5px solid #0d6efd;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #e7f1ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            flex-shrink: 0;
        }

        .info-text strong {
            display: block;
            font-size: 17px;
            margin-bottom: 4px;
            color: #555;
        }

        .info-text span {
            display: block;
            font-size: 20px;
            font-weight: 600;
            color: #172033;
        }

        /* ==========================================
           DESKRIPSI
        ========================================== */

        .description-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .description-card h2 {
            color: #0d6efd;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .description-card p {
            font-size: 18px;
            line-height: 1.8;
            color: #444;
            margin-bottom: 15px;
        }

        /* ==========================================
           TUJUAN
        ========================================== */

        .purpose-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .purpose-card h2 {
            color: #0d6efd;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 25px;
        }

        .purpose-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding: 18px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .purpose-number {
            width: 38px;
            height: 38px;
            min-width: 38px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .purpose-item p {
            margin: 0;
            font-size: 17px;
            line-height: 1.6;
        }

        /* ==========================================
           FOOTER
        ========================================== */

        footer {
            background: white;
            border-top: 1px solid #ddd;
            text-align: center;
            padding: 25px 20px;
            color: #666;
        }

        footer strong {
            color: #0d6efd;
        }

        /* ==========================================
           RESPONSIVE
        ========================================== */

        @media (max-width: 991px) {

            .navbar-brand {
                margin-bottom: 10px;
            }

            .nav-link {
                margin: 5px 0;
            }

            .user-area {
                margin-top: 15px;
            }

            .hero h1 {
                font-size: 40px;
            }

        }

        @media (max-width: 576px) {

            .hero {
                padding-top: 45px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .hero p {
                font-size: 17px;
            }

            .profile-card,
            .description-card,
            .purpose-card {
                padding: 25px;
            }

            .info-box {
                align-items: flex-start;
            }

            .info-text span {
                font-size: 17px;
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
        <a class="navbar-brand text-decoration-none"
           href="index.php">

            <img
                src="assets/img/logo.png"
                alt="Logo TechQuest"
            >

            <div class="ms-2">

                <div class="brand-title">
                    TechQuest
                </div>

                <div class="brand-subtitle">
                    Teknik Komputer dan Jaringan
                </div>

            </div>

        </a>


        <!-- TOGGLE -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuNavbar"
            aria-controls="menuNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
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
                        class="nav-link active"
                        href="kontak.php"
                    >
                        Kontak
                    </a>
                </li>

            </ul>


            <!-- USER -->
            <div class="d-flex align-items-center gap-3 user-area">

                <span class="user-name">
                    Halo,
                    <?php echo htmlspecialchars($namaUser); ?>
                </span>

                <a
                    href="auth/logout.php"
                    class="btn-logout"
                >
                    Logout
                </a>

            </div>

        </div>

    </div>

</nav>


<!-- ==========================================
     HERO
========================================== -->

<section class="hero">

    <div class="hero-icon">
        👨‍💻
    </div>

    <h1>
        Kontak & Profil
    </h1>

    <p>
        Informasi pembuat website TechQuest
    </p>

</section>


<!-- ==========================================
     CONTENT
========================================== -->

<div class="content-container">


    <!-- PROFIL PEMBUAT -->

    <div class="profile-card">

        <div class="profile-title">

            <h2>
                👥 Profil Pembuat
            </h2>

            <p>
                Tim yang mengembangkan website TechQuest
            </p>

        </div>


        <!-- PEMBUAT -->

        <div class="info-box">

            <div class="info-icon">
                👥
            </div>

            <div class="info-text">

                <strong>
                    Pembuat Website
                </strong>

                <span>
                    Kelompok PJBL 1
                </span>

            </div>

        </div>


        <!-- SEKOLAH -->

        <div class="info-box">

            <div class="info-icon">
                🏫
            </div>

            <div class="info-text">

                <strong>
                    Sekolah
                </strong>

                <span>
                    SMK NEGERI 12 MALANG
                </span>

            </div>

        </div>


        <!-- JURUSAN -->

        <div class="info-box">

            <div class="info-icon">
                💻
            </div>

            <div class="info-text">

                <strong>
                    Jurusan
                </strong>

                <span>
                    Teknik Komputer dan Jaringan
                </span>

            </div>

        </div>


        <!-- PROJECT -->

        <div class="info-box">

            <div class="info-icon">
                📚
            </div>

            <div class="info-text">

                <strong>
                    Kegiatan
                </strong>

                <span>
                    Project Based Learning (PJBL)
                </span>

            </div>

        </div>

    </div>


    <!-- TENTANG PEMBUAT -->

    <div class="description-card">

        <h2>
            💡 Tentang Pembuat
        </h2>

        <p>

            Website <strong>TechQuest</strong> dibuat oleh
            <strong>Kelompok PJBL 1</strong> dari
            <strong>SMK NEGERI 12 MALANG</strong>,
            Jurusan <strong>Teknik Komputer dan Jaringan</strong>.

        </p>

        <p>

            Website ini dikembangkan sebagai bagian dari
            kegiatan <strong>Project Based Learning (PJBL)</strong>
            dengan tujuan membuat sebuah media pembelajaran
            berbasis website yang dapat digunakan untuk
            membantu siswa dalam mempelajari materi
            Teknik Komputer dan Jaringan.

        </p>

        <p>

            TechQuest menyediakan beberapa fitur pembelajaran,
            seperti materi TKJ, quiz, hasil nilai, riwayat nilai,
            serta sistem peringkat peserta.

        </p>

    </div>


    <!-- TUJUAN WEBSITE -->

    <div class="purpose-card">

        <h2>
            🎯 Tujuan Website
        </h2>


        <div class="purpose-item">

            <div class="purpose-number">
                1
            </div>

            <p>
                Menyediakan media pembelajaran Teknik Komputer
                dan Jaringan yang mudah digunakan oleh siswa.
            </p>

        </div>


        <div class="purpose-item">

            <div class="purpose-number">
                2
            </div>

            <p>
                Membantu siswa memahami materi jaringan komputer
                melalui pembelajaran berbasis website.
            </p>

        </div>


        <div class="purpose-item">

            <div class="purpose-number">
                3
            </div>

            <p>
                Menyediakan quiz sebagai sarana untuk menguji
                pemahaman siswa terhadap materi yang telah dipelajari.
            </p>

        </div>


        <div class="purpose-item">

            <div class="purpose-number">
                4
            </div>

            <p>
                Menampilkan hasil nilai dan peringkat secara
                otomatis sehingga siswa dapat mengetahui
                pencapaian mereka.
            </p>

        </div>


        <div class="purpose-item">

            <div class="purpose-number">
                5
            </div>

            <p>
                Menerapkan kemampuan pemrograman web yang
                diperoleh dalam kegiatan Project Based Learning.
            </p>

        </div>

    </div>

</div>


<!-- ==========================================
     FOOTER
========================================== -->

<footer>

    <div>
        <strong>TechQuest</strong>
        &copy; <?php echo date('Y'); ?>
    </div>

    <div>
        Kelompok PJBL 1 -
        SMK NEGERI 12 MALANG
    </div>

</footer>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>