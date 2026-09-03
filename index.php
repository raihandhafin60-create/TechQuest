<?php

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| KONEKSI DATABASE
|--------------------------------------------------------------------------
*/

require_once __DIR__ . "/config/koneksi.php";


/*
|--------------------------------------------------------------------------
| DATA SESSION USER
|--------------------------------------------------------------------------
*/

$user_id = isset($_SESSION['user_id'])
    ? (int) $_SESSION['user_id']
    : 0;

$nama_user = $_SESSION['nama'] ?? 'Pengunjung';


/*
|--------------------------------------------------------------------------
| PENCARIAN QUIZ
|--------------------------------------------------------------------------
*/

$cari = trim($_GET['cari'] ?? '');

$cari_aman = mysqli_real_escape_string(
    $conn,
    $cari
);


/*
|--------------------------------------------------------------------------
| FILTER KATEGORI
|--------------------------------------------------------------------------
*/

$filter = trim($_GET['kategori'] ?? '');

$filter_aman = mysqli_real_escape_string(
    $conn,
    $filter
);


/*
|--------------------------------------------------------------------------
| TOTAL QUIZ
|--------------------------------------------------------------------------
*/

$queryTotalQuiz = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM kategori"
);

$totalQuiz = 0;

if ($queryTotalQuiz) {

    $dataTotalQuiz =
        mysqli_fetch_assoc($queryTotalQuiz);

    $totalQuiz =
        (int) ($dataTotalQuiz['total'] ?? 0);
}


/*
|--------------------------------------------------------------------------
| TOTAL SOAL
|--------------------------------------------------------------------------
*/

$queryTotalSoal = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM soal"
);

$totalSoal = 0;

if ($queryTotalSoal) {

    $dataTotalSoal =
        mysqli_fetch_assoc($queryTotalSoal);

    $totalSoal =
        (int) ($dataTotalSoal['total'] ?? 0);
}


/*
|--------------------------------------------------------------------------
| TOTAL PENGGUNA
|--------------------------------------------------------------------------
*/

$queryTotalUser = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users"
);

$totalUser = 0;

if ($queryTotalUser) {

    $dataTotalUser =
        mysqli_fetch_assoc($queryTotalUser);

    $totalUser =
        (int) ($dataTotalUser['total'] ?? 0);
}


/*
|--------------------------------------------------------------------------
| DATA KATEGORI UNTUK FILTER
|--------------------------------------------------------------------------
*/

$queryKategori = mysqli_query(
    $conn,
    "SELECT id, nama_kategori
     FROM kategori
     ORDER BY id ASC"
);

if (!$queryKategori) {

    die(
        "Query kategori gagal: " .
        mysqli_error($conn)
    );

}


/*
|--------------------------------------------------------------------------
| DATA QUIZ
|--------------------------------------------------------------------------
|
| Struktur tabel kamu:
|
| kategori
|   id
|   nama_kategori
|
| soal
|   id
|   kategori
|
| Kolom soal.kategori berisi nama kategori.
|
|--------------------------------------------------------------------------
*/

$sqlQuiz = "
    SELECT
        k.id,
        k.nama_kategori,
        COUNT(s.id) AS jumlah_soal
    FROM kategori k
    LEFT JOIN soal s
        ON s.kategori = k.nama_kategori
";


$where = [];


/*
|--------------------------------------------------------------------------
| PENCARIAN
|--------------------------------------------------------------------------
*/

if ($cari !== '') {

    $where[] =
        "k.nama_kategori LIKE '%$cari_aman%'";

}


/*
|--------------------------------------------------------------------------
| FILTER
|--------------------------------------------------------------------------
*/

if ($filter !== '') {

    $where[] =
        "k.nama_kategori = '$filter_aman'";

}


/*
|--------------------------------------------------------------------------
| WHERE
|--------------------------------------------------------------------------
*/

if (count($where) > 0) {

    $sqlQuiz .=
        " WHERE " .
        implode(" AND ", $where);

}


/*
|--------------------------------------------------------------------------
| GROUP BY
|--------------------------------------------------------------------------
*/

$sqlQuiz .= "
    GROUP BY
        k.id,
        k.nama_kategori
    ORDER BY
        k.id ASC
";


$queryQuiz = mysqli_query(
    $conn,
    $sqlQuiz
);


if (!$queryQuiz) {

    die(
        "Query quiz gagal: " .
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

    <title>TechQuest</title>


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    >


    <!-- CSS UTAMA -->

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/home.css"
    >

</head>


<body>


<?php include "includes/navbar.php"; ?>


<!-- =====================================================
     HERO
===================================================== -->


<section class="hero d-flex align-items-center">

    <div class="container">

        <div class="row align-items-center">

            <!-- Kiri -->
            <div class="col-lg-6">

                <span class="badge bg-primary px-3 py-2 mb-3">
                    🚀 Platform Belajar Teknologi
                </span>

                <h1 class="display-3 fw-bold text-white">
                    Semua
                    <span class="text-info">BISA !!!</span>,
                    <br>
                    Asal Mau
                   
                </h1>

                <p class="lead mt-4 mb-4">
                    TechQuest merupakan platform pembelajaran interaktif
                    untuk Teknik Komputer dan Jaringan.
                    Belajar melalui quiz, materi, leaderboard,
                    dan tantangan yang menyenangkan.
                </p>

                <a href="quiz/index.php"
                   class="btn btn-primary btn-lg px-4 me-2">
                    Mulai Belajar
                </a>

                <a href="materi/index.php"
                   class="btn btn-outline-light btn-lg px-4">
                    Jelajahi Materi
                </a>

            </div>

            <!-- Kanan -->
            <div class="col-lg-6 text-center">

                <img src="assets/img/hero.png"
                     class="img-fluid floating"
                     style="max-width:520px;">

            </div>

        </div>

    </div>

</section>

<!-- =====================================================
     FEATURES
===================================================== -->

<section class="features py-5">

    <div class="container">

        <div class="row g-4">


            <!-- QUIZ -->

            <div class="col-md-3">

                <div
                    class="card shadow-sm border-0 h-100 text-center p-4"
                >

                    <i
                        class="bi bi-journal-bookmark fs-1 text-primary"
                    ></i>


                    <h5 class="mt-3">

                        Quiz Interaktif

                    </h5>


                    <p>

                        Belajar sambil mengerjakan quiz
                        yang menarik.

                    </p>

                </div>

            </div>


            <!-- TOPIK -->

            <div class="col-md-3">

                <div
                    class="card shadow-sm border-0 h-100 text-center p-4"
                >

                    <i
                        class="bi bi-bullseye fs-1 text-primary"
                    ></i>


                    <h5 class="mt-3">

                        Beragam Topik

                    </h5>


                    <p>

                        Materi dari dasar hingga lanjutan.

                    </p>

                </div>

            </div>


            <!-- PERINGKAT -->

            <div class="col-md-3">

                <div
                    class="card shadow-sm border-0 h-100 text-center p-4"
                >

                    <i
                        class="bi bi-trophy fs-1 text-primary"
                    ></i>


                    <h5 class="mt-3">

                        Peringkat

                    </h5>


                    <p>

                        Bersaing dengan temanmu.

                    </p>

                </div>

            </div>


            <!-- PROGRESS -->

            <div class="col-md-3">

                <div
                    class="card shadow-sm border-0 h-100 text-center p-4"
                >

                    <i
                        class="bi bi-graph-up fs-1 text-primary"
                    ></i>


                    <h5 class="mt-3">

                        Pantau Progress

                    </h5>


                    <p>

                        Lihat perkembangan belajarmu.

                    </p>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     DAFTAR QUIZ
===================================================== -->

<section class="quiz-list py-5">

    <div class="container">


        <!-- HEADER -->

        <div
            class="d-flex justify-content-between align-items-center mb-4"
        >

            <h2 class="fw-bold">

                Daftar Quiz

            </h2>


            <!-- PENCARIAN -->

            <form
                method="GET"
                action="index.php"
                style="width:300px;"
            >

                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="Cari Quiz..."
                    value="<?= htmlspecialchars($cari); ?>"
                >

            </form>

        </div>



        <!-- =================================================
             STATISTIK
        ================================================== -->

        <div class="row text-center mb-5">


            <div class="col-md-4">

                <h2>

                    <?= $totalQuiz; ?>

                </h2>

                <p>

                    Total Quiz

                </p>

            </div>


            <div class="col-md-4">

                <h2>

                    <?= $totalSoal; ?>

                </h2>

                <p>

                    Total Soal

                </p>

            </div>


            <div class="col-md-4">

                <h2>

                    <?= $totalUser; ?>

                </h2>

                <p>

                    Pengguna

                </p>

            </div>


        </div>



        <!-- =================================================
             FILTER KATEGORI
        ================================================== -->

        <div class="mb-4">


            <!-- SEMUA -->

            <a
                href="index.php"
                class="btn btn-sm
                <?= $filter === ''
                    ? 'btn-primary'
                    : 'btn-outline-primary'; ?>"
            >

                Semua

            </a>


            <?php

            /*
             * Karena query kategori akan dipakai
             * untuk tombol filter, kita ambil ulang.
             */

            mysqli_data_seek(
                $queryKategori,
                0
            );

            ?>


            <?php while (
                $kat = mysqli_fetch_assoc($queryKategori)
            ): ?>


                <?php

                $namaKat =
                    $kat['nama_kategori'];

                ?>


                <a
                    href="index.php?kategori=<?= urlencode($namaKat); ?>"
                    class="btn btn-sm
                    <?= $filter === $namaKat
                        ? 'btn-primary'
                        : 'btn-outline-primary'; ?>"
                >

                    <?= htmlspecialchars($namaKat); ?>

                </a>


            <?php endwhile; ?>


        </div>



        <!-- =================================================
             LIST QUIZ
        ================================================== -->

        <div class="row">

            <div class="col-12">


                <?php if (
                    mysqli_num_rows($queryQuiz) > 0
                ): ?>


                    <?php while (
                        $quiz =
                        mysqli_fetch_assoc($queryQuiz)
                    ): ?>


                        <?php

                        $idKategori =
                            (int) $quiz['id'];

                        $namaKategori =
                            $quiz['nama_kategori'];

                        $jumlahSoal =
                            (int) $quiz['jumlah_soal'];


                        /*
                         * DEFAULT
                         */

                        $skorTertinggi = 0;


                        /*
                         * AMBIL SKOR USER
                         */

                        if ($user_id > 0) {

                            $stmtScore =
                                mysqli_prepare(
                                    $conn,
                                    "SELECT MAX(skor) AS skor
                                     FROM hasil_quiz
                                     WHERE user_id = ?
                                     AND kategori_id = ?"
                                );


                            if ($stmtScore) {

                                mysqli_stmt_bind_param(
                                    $stmtScore,
                                    "ii",
                                    $user_id,
                                    $idKategori
                                );


                                mysqli_stmt_execute(
                                    $stmtScore
                                );


                                $resultScore =
                                    mysqli_stmt_get_result(
                                        $stmtScore
                                    );


                                if ($resultScore) {

                                    $dataScore =
                                        mysqli_fetch_assoc(
                                            $resultScore
                                        );


                                    $skorTertinggi =
                                        (int) (
                                            $dataScore['skor']
                                            ?? 0
                                        );

                                }


                                mysqli_stmt_close(
                                    $stmtScore
                                );

                            }

                        }

                        ?>


                        <!-- =================================================
                             CARD QUIZ
                        ================================================== -->

                        <div class="quiz-card">


                            <!-- ICON -->

                            <div class="quiz-icon">

                                <i
                                    class="bi bi-pc-display"
                                ></i>

                            </div>



                            <!-- CONTENT -->

                            <div class="quiz-content">


                                <div
                                    class="d-flex justify-content-between align-items-center mb-2"
                                >

                                    <h5 class="mb-0">

                                        <?= htmlspecialchars(
                                            $namaKategori
                                        ); ?>

                                    </h5>


                                    <span
                                        class="badge bg-success"
                                    >

                                        Terbaru

                                    </span>

                                </div>


                                <p>

                                    Quiz tentang
                                    <?= htmlspecialchars(
                                        $namaKategori
                                    ); ?>.

                                </p>


                                <small>

                                    <i
                                        class="bi bi-file-earmark"
                                    ></i>


                                    <?= $jumlahSoal; ?>

                                    Soal


                                    &nbsp;&nbsp;


                                    <?php

                                    /*
                                     * LEVEL BERDASARKAN
                                     * JUMLAH SOAL
                                     */

                                    if ($jumlahSoal <= 20) {

                                        $level =
                                            'Mudah';

                                        $levelClass =
                                            'text-success';

                                    } elseif (
                                        $jumlahSoal <= 30
                                    ) {

                                        $level =
                                            'Sedang';

                                        $levelClass =
                                            'text-warning';

                                    } else {

                                        $level =
                                            'Sulit';

                                        $levelClass =
                                            'text-danger';

                                    }

                                    ?>


                                    <span
                                        class="<?= $levelClass; ?>"
                                    >

                                        ●
                                        <?= $level; ?>

                                    </span>

                                </small>


                            </div>



                            <!-- SCORE -->

                            <div class="quiz-score">


                                <h4>

                                    <?= $skorTertinggi; ?>%

                                </h4>


                                <small>

                                    Skor Tertinggi

                                </small>


                                <div
                                    class="progress mt-2"
                                    style="height:8px;"
                                >

                                    <div
                                        class="progress-bar bg-primary"
                                        style="
                                            width:
                                            <?= $skorTertinggi; ?>%;
                                        "
                                    ></div>

                                </div>


                                <small
                                    class="text-muted"
                                >

                                    Progress
                                    <?= $skorTertinggi; ?>%

                                </small>


                            </div>



                            <!-- TOMBOL -->

                            <div class="quiz-action">


                                <a
                                    href="quiz/mulai.php?kategori=<?= $idKategori; ?>"
                                    class="btn btn-primary px-4 py-2"
                                >

                                    Mulai

                                </a>


                            </div>


                        </div>


                    <?php endwhile; ?>


                <?php else: ?>


                    <!-- TIDAK ADA QUIZ -->

                    <div
                        class="alert alert-warning text-center"
                    >

                        <?php if ($cari !== ''): ?>

                            Quiz dengan kata

                            <strong>

                                <?= htmlspecialchars(
                                    $cari
                                ); ?>

                            </strong>

                            tidak ditemukan.


                        <?php elseif ($filter !== ''): ?>

                            Tidak ada quiz untuk kategori

                            <strong>

                                <?= htmlspecialchars(
                                    $filter
                                ); ?>

                            </strong>.


                        <?php else: ?>

                            Belum ada quiz yang tersedia.

                        <?php endif; ?>

                    </div>


                <?php endif; ?>


            </div>

        </div>

    </div>

</section>



<!-- =====================================================
     MATERI TERBARU
===================================================== -->

<section class="py-5 bg-white">

    <div class="container">


        <div class="text-center mb-5">

            <h2 class="fw-bold">

                📚 Materi Terbaru

            </h2>


            <p class="text-muted">

                Pelajari materi sebelum mengerjakan quiz.

            </p>

        </div>


        <div class="row g-4">


            <!-- MATERI 1 -->

            <div class="col-md-4">

                <div
                    class="card border-0 shadow-sm h-100"
                >

                    <div class="card-body">

                        <i
                            class="bi bi-router fs-1 text-primary"
                        ></i>


                        <h5 class="mt-3">

                            Dasar Jaringan

                        </h5>


                        <p class="text-muted">

                            Mengenal konsep dasar
                            jaringan komputer.

                        </p>


                        <a
                            href="materi/index.php"
                            class="btn btn-outline-primary"
                        >

                            Baca Materi

                        </a>

                    </div>

                </div>

            </div>



            <!-- MATERI 2 -->

            <div class="col-md-4">

                <div
                    class="card border-0 shadow-sm h-100"
                >

                    <div class="card-body">

                        <i
                            class="bi bi-hdd-network fs-1 text-success"
                        ></i>


                        <h5 class="mt-3">

                            Topologi Jaringan

                        </h5>


                        <p class="text-muted">

                            Pelajari berbagai macam
                            topologi jaringan.

                        </p>


                        <a
                            href="materi/index.php"
                            class="btn btn-outline-success"
                        >

                            Baca Materi

                        </a>

                    </div>

                </div>

            </div>



            <!-- MATERI 3 -->

            <div class="col-md-4">

                <div
                    class="card border-0 shadow-sm h-100"
                >

                    <div class="card-body">

                        <i
                            class="bi bi-shield-lock fs-1 text-danger"
                        ></i>


                        <h5 class="mt-3">

                            Keamanan Jaringan

                        </h5>


                        <p class="text-muted">

                            Dasar keamanan dalam
                            jaringan komputer.

                        </p>


                        <a
                            href="materi/index.php"
                            class="btn btn-outline-danger"
                        >

                            Baca Materi

                        </a>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     PERINGKAT
===================================================== -->

<section class="py-5 bg-light">

    <div class="container">


        <div class="text-center mb-5">

            <h2 class="fw-bold">

                🏆 Peringkat Siswa

            </h2>


            <p class="text-muted">

                Siswa dengan skor terbaik.

            </p>

        </div>


        <div class="table-responsive">

            <table
                class="table table-striped table-hover align-middle"
            >

                <thead class="table-primary">

                    <tr>

                        <th>
                            Peringkat
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            Skor
                        </th>

                    </tr>

                </thead>


                <tbody>


                    <?php

                    /*
                     * Ambil ranking dari hasil quiz.
                     *
                     * Menggunakan users.nama jika
                     * kolom tersebut tersedia.
                     */

                    $queryRanking = mysqli_query(
                        $conn,
                        "SELECT
                            u.nama,
                            SUM(h.skor) AS total_skor
                         FROM hasil_quiz h
                         INNER JOIN users u
                            ON u.id = h.user_id
                         GROUP BY
                            h.user_id,
                            u.nama
                         ORDER BY
                            total_skor DESC
                         LIMIT 5"
                    );

                    ?>


                    <?php

                    if (
                        $queryRanking &&
                        mysqli_num_rows(
                            $queryRanking
                        ) > 0
                    ):

                    ?>



                        <?php

                        $peringkat = 1;

                        ?>


                        <?php while (
                            $rank =
                            mysqli_fetch_assoc(
                                $queryRanking
                            )
                        ): ?>


                            <tr>

                                <td>

                                    <?php

                                    if (
                                        $peringkat === 1
                                    ) {

                                        echo "🥇 1";

                                    } elseif (
                                        $peringkat === 2
                                    ) {

                                        echo "🥈 2";

                                    } elseif (
                                        $peringkat === 3
                                    ) {

                                        echo "🥉 3";

                                    } else {

                                        echo $peringkat;

                                    }

                                    ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $rank['nama']
                                    ); ?>

                                </td>


                                <td>

                                    <?= (int)
                                        $rank['total_skor']; ?>

                                </td>

                            </tr>


                            <?php

                            $peringkat++;

                            ?>


                        <?php endwhile; ?>


                    <?php else: ?>


                        <tr>

                            <td
                                colspan="3"
                                class="text-center text-muted"
                            >

                                Belum ada data peringkat.

                            </td>

                        </tr>


                    <?php endif; ?>


                </tbody>

            </table>

        </div>

    </div>

</section>



<!-- =====================================================
     FOOTER
===================================================== -->

<footer class="bg-dark text-white py-4">

    <div class="container text-center">


        <h5>

            TechQuest

        </h5>


        <p>

            Platform pembelajaran Teknik Komputer
            dan Jaringan

        </p>


        <small>

            © 2026 TechQuest

        </small>


    </div>

</footer>



<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>