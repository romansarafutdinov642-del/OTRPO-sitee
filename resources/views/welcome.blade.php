<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <title>Кино</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
<header>
    <nav class="navbar shadow-sm rounded-3 my-2 mx-auto" style="max-width: 1800px;">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="images/TheShining.webp" alt="logo" width="40" height="30" class="d-inline-block align-text-top me-2 labelIMG">
                <span class="fw-bold">Актеры всех времен</span>
            </a>

            <button class="btn px-3 py-1 rounded-3" id="liveToastBtn">Загрузить</button>

            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="fa-solid fa-spinner me-auto" id="failedLoad"></i>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        Функционал на данный момент не доступен.
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div class="container my-3">
    <h1>Джек Николсон</h1>

    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3
        row-cols-xl-3 row-cols-xxl-4 row-cols-xxxl-5 justify-content-center g-3">

        <div class="col">
            <div class="card h-100 shadow-sm rounded-3" data-index="0">
                <div class="position-relative">
                    <img src="images/film_the_shining.jpg" class="img-fluid rounded-3" alt="poster_the_shining">
                    <span class="badge">Фильмы</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Сияние</h5>
                    <p class="card-text">
                        Фильм «Сияние» (1980) — культовый хоррор Станли Кубрика.
                        Джек Николсон сыграл роль писателя Джека Торранса, постепенно теряющего рассудок…
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow-sm" data-index="1">
                <div class="position-relative">
                    <img src="images/film_kukushka.jpg" class="img-fluid rounded-3" alt="poster_the_kukushka">
                    <span class="badge">Фильмы</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Пролетая над гнездом кукушки</h5>
                    <p class="card-text">
                        В драме «Пролетая над гнездом кукушки» (1975) Джек Николсон…
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow-sm" data-index="2">
                <div class="position-relative">
                    <img src="images/film_batman.webp" class="img-fluid rounded-3" alt="poster_batman">
                    <span class="badge">Фильмы</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Бэтмен</h5>
                    <p class="card-text">
                        В фильме «Бэтмен» (1989) Джек Николсон…
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow-sm" data-index="3">
                <div class="position-relative">
                    <img src="images/oskar_1976.jpg" class="img-fluid rounded-3" alt="award_oscar_1976">
                    <span class="badge">Награды</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Оскар (1976)</h5>
                    <p class="card-text">
                        Джек Николсон получил свою первую премию «Оскар»…
                    </p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 shadow-sm" data-index="4">
                <div class="position-relative">
                    <img src="images/award_golden_global_1976_.jpg" class="img-fluid rounded-3" alt="award_golden_global_1976">
                    <span class="badge">Награды</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Золотой глобус (1976)</h5>
                    <p class="card-text">
                        В 1976 году Джек Николсон получил «Золотой глобус»…
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Модалка --}}
<div class="modal fade" id="detailModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img id="modalImage" src="#" class="img-fluid rounded-3" alt="">
                    </div>
                    <div class="col-md-7">
                        <p id="modalDescription"></p>
                        <p id="modalDetails"></p>
                    </div>
                </div>

                <div class="modal-navigation">
                    <button class="btn" id="prevBtn">Предыдущий</button>
                    <button class="btn" id="nextBtn">Следующий</button>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="footer-content">
        <div class="info">
            <p>prod. Letita Matvey</p>
        </div>
        <div class="social-link">
            <a href="https://max.ru/" target="_blank">
                <img src="images/logo_max.jpg" alt="logo max">
            </a>
            <a href="https://dzen.ru/" target="_blank">
                <img src="images/logo_dzen.png" alt="logo dzen">
            </a>
            <a href="https://claude.com/" target="_blank">
                <img src="images/logo_claude.jfif" alt="logo claude">
            </a>
        </div>
    </div>
</footer>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
