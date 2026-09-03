<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tentang - TechQuest</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f5f8ff;
            font-family: Arial, sans-serif;
        }

        .about-section {
            padding: 70px 20px;
        }

        .about-card {
            background: white;
            max-width: 1000px;
            margin: auto;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .about-title {
            text-align: center;
            font-size: 42px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 15px;
        }

        .about-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 19px;
            margin-bottom: 45px;
        }

        .about-card h3 {
            color: #0d6efd;
            font-weight: 700;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .about-card p {
            font-size: 17px;
            line-height: 1.8;
            color: #333;
            text-align: justify;
        }

        .tujuan {
            background: #f0f6ff;
            padding: 25px;
            border-radius: 15px;
            margin-top: 20px;
        }

        .tujuan ul {
            margin-bottom: 0;
        }

        .tujuan li {
            margin-bottom: 12px;
            font-size: 16px;
        }

        .footer {
            text-align: center;
            padding: 30px;
            color: #6c757d;
        }
    </style>

</head>

<body>


<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">

    <div class="container">

        <!-- Logo / Brand -->

        <a class="navbar-brand d-flex align-items-center"
           href="index.php">

            <img
                src="assets/img/logo.png"
                width="55"
                height="55"
                class="me-2"
                alt="Logo TechQuest"
            >

            <div>
                <h5 class="m-0 fw-bold text-primary">
                    TechQuest
                </h5>

                <small>
                    Teknik Komputer dan Jaringan
                </small>
            </div>

        </a>


        <!-- Tombol Mobile -->

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menu"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- Menu -->

        <div
            class="collapse navbar-collapse"
            id="menu"
        >

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">
                    <a
                        class="nav-link px-3"
                        href="index.php"
                    >
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link px-3"
                        href="quiz/index.php"
                    >
                        Quiz
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link px-3"
                        href="materi/index.php"
                    >
                        Materi
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link px-3"
                        href="peringkat.php"
                    >
                        Peringkat
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link active px-3 fw-bold text-primary"
                        href="tentang.php"
                    >
                        Tentang
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link px-3"
                        href="kontak.php"
                    >
                        Kontak
                    </a>
                </li>

            </ul>


            <!-- User -->

            <?php if (isset($_SESSION['login'])) { ?>

                <div class="d-flex align-items-center gap-3">

                    <span>
                        Halo,
                        <?php
                        echo htmlspecialchars(
                            $_SESSION['nama']
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

            <?php } else { ?>

                <div class="d-flex gap-2">

                    <a
                        href="auth/login.php"
                        class="btn btn-outline-primary"
                    >
                        Masuk
                    </a>

                    <a
                        href="auth/register.php"
                        class="btn btn-primary"
                    >
                        Daftar
                    </a>

                </div>

            <?php } ?>

        </div>

    </div>

</nav>


<!-- ================= TENTANG ================= -->

<section class="about-section">

    <div class="about-card">

        <h1 class="about-title">
            📘 Tentang TechQuest
        </h1>

        <p class="about-subtitle">
            Platform pembelajaran dan latihan soal
            Teknik Komputer dan Jaringan
        </p>


        <!-- Tentang Web -->

        <h3>
            Apa itu TechQuest?
        </h3>

        <p>
            <strong>TechQuest</strong> merupakan website pembelajaran
            yang dibuat untuk membantu siswa dalam mempelajari
            materi Teknik Komputer dan Jaringan (TKJ).
            Website ini menyediakan materi pembelajaran,
            latihan soal, quiz, hasil nilai, serta sistem
            peringkat peserta.
        </p>


        <!-- Tujuan -->

        <h3>
            🎯 Tujuan Website
        </h3>

        <div class="tujuan">

            <ul>

                <li>
                    Membantu siswa memahami materi
                    Teknik Komputer dan Jaringan.
                </li>

                <li>
                    Menyediakan media latihan soal
                    yang mudah digunakan.
                </li>

                <li>
                    Membantu siswa mengukur kemampuan
                    melalui hasil quiz.
                </li>

                <li>
                    Meningkatkan motivasi belajar siswa
                    melalui sistem peringkat.
                </li>

                <li>
                    Menyediakan media pembelajaran
                    yang dapat digunakan secara online.
                </li>

            </ul>

        </div>


        <!-- Fitur -->

        <h3>
            💡 Fitur Website
        </h3>

        <p>
            TechQuest memiliki beberapa fitur utama,
            yaitu materi pembelajaran, quiz pilihan ganda,
            perhitungan nilai secara otomatis, riwayat nilai,
            dan peringkat peserta berdasarkan nilai terbaik.
        </p>


        <!-- Manfaat -->

        <h3>
            📚 Manfaat
        </h3>

        <p>
            Dengan adanya TechQuest, siswa dapat belajar
            materi TKJ dan menguji pemahamannya melalui
            quiz secara lebih praktis. Hasil quiz dapat
            digunakan sebagai bahan evaluasi untuk mengetahui
            sejauh mana pemahaman siswa terhadap materi
            yang telah dipelajari.
        </p>


        <!-- Penutup -->

        <h3>
            🚀 Harapan
        </h3>

        <p>
            Diharapkan TechQuest dapat menjadi salah satu
            media pembelajaran yang bermanfaat bagi siswa
            Teknik Komputer dan Jaringan serta membantu
            menciptakan proses belajar yang lebih menarik,
            interaktif, dan mudah digunakan.
        </p>

    </div>

</section>


<!-- ================= FOOTER ================= -->

<footer class="footer">

    <p class="mb-0">
        © 2026 TechQuest -
        Teknik Komputer dan Jaringan
    </p>

</footer>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>