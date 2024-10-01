<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinLog</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/icon/mw.png') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark px-4">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/icon/mw.png') }}" width="35" height="35" class="d-inline-block align-top" alt="mw Icon">
                <span id="text-brand" class="text-white">FinLog</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link menu text-white mx-2" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu text-white mx-2" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu text-white mx-2" href="#benefits">Benefits</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>


    <main>
        <section id="home" class="section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-8 col-sm-12 px-5 text-center text-lg-left">
                        <h1 class="text-light font-weight-bold">
                            <span class="d-block mt-3">Manajemen Keuangan anda dengan
                                <span class="text-gradient"> Finlog</span>
                            </span> <!-- Menyesuaikan margin -->
                            <!-- Pastikan ada satu spasi di sini -->
                        </h1>
                        <p class="text-secondary animation-text">Alat manajemen keuangan yang membantu mengelola keuangan anda</p>
                        <a href="/login" class="btn btn-primary btn-lg">Get Started</a>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block"> <!-- Hanya tampil di desktop -->
                        <img src="{{ asset('assets/img/finance.png') }}" style="width: 60%;" alt="FinLog App" class="img-fluid">
                    </div>
                </div>
            </div>
            </div>
        </section>


        <section id="about">
            <div class="container highlight-background">
                <div class="row align-items-center">
                    <div id="image-aboute" class="col-lg-6 order-lg-1 order-2">
                        <img src="{{ asset('assets/img/finance2.png') }}" class="img-fluid rounded-circle" alt="FinLog Image">
                    </div>
                    <div id="title-about" class="col-lg-6 order-lg-2 order-1 px-5">
                        <h1 class="section-title text-light mt-5">About <span class="text-gradient">Finlog</span></h1>
                        <p class="section-description text-light">FinLog dibuat untuk mengatasi tantangan umum yang dihadapi orang-orang dalam mengelola keuangan pribadi mereka. Tujuan kami adalah menyediakan platform yang mudah digunakan yang membantu pengguna melacak pendapatan, pengeluaran, dan tabungan mereka, serta membuat keputusan keuangan yang tepat.</p>
                        <a href="#" class="btn btn-secondary">Need Help</a>
                    </div>
                </div>
            </div>
        </section>



        <section id="benefits">
            <div class="container">
                <h2 class="mt-5 text-center text-light">Benefits of Using <span class="text-gradient">Finlog</span></h2>
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <ul class="list-group list-group-flush mt-4">
                            <li class="list-group-item border-0">
                                <i class="fas fa-check-circle text-success mr-2"></i> Pelacakan pemasukan dan pengeluaran yang mudah
                            </li>
                            <li class="list-group-item border-0">
                                <i class="fas fa-check-circle text-success mr-2"></i> Laporan keuangan yang rinci
                            </li>
                            <li class="list-group-item border-0">
                                <i class="fas fa-check-circle text-success mr-2"></i> Anggaran peraencanaan yang personal
                            </li>
                            <li class="list-group-item border-0">
                                <i class="fas fa-check-circle text-success mr-2"></i> Penetapan dan pelacakan tujuan keuangan
                            </li>
                            <li class="list-group-item border-0">
                                <i class="fas fa-check-circle text-success mr-2"></i> Antarmuka pengguna yang ramah
                            </li>
                            <li class="list-group-item border-0">
                                <i class="fas fa-check-circle text-success mr-2"></i> Manajemen data yang aman dan pribadi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <footer>
        @include('footer.footer')
    </footer>
</body>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/home.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>