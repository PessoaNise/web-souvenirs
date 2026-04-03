<?php

$PageTitle = "Tizauvenirs";

include '../resources/templates/head.html';
include '../resources/templates/header.html';
?>
    <!--Banner-->
    <section style="background-image: url('assets/img/banner-of-working-desk-with-gadget-top-view.jpg');background-repeat: no-repeat;background-size: cover;">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-6 pt-5 mt-5"></div>
                <div class="col-md-6 pt-5 mt-5">
                    <h2 class="display-1 ls-1 mb-3"><span class="fw-bold text-primary">Tizauvenirs</span>
                        <p class="text-black-50">Artículos para ñoños de la </p><span class="fw-bold text-success">Programación!</span></h2>
                    <!--                    <p class="fs-4">Dignissim massa diam elementum.</p>-->
                    <div class="d-flex gap-3">
                        <a href="login.php" class="btn btn-primary text-uppercase fs-6 rounded-pill px-4 py-3 mt-3">Acceder</a>
                        <a href="usuario_registro.php" class="btn btn-dark text-uppercase fs-6 rounded-pill px-4 py-3 mt-3">Registrarse</a>
                    </div>
                    <div class="row my-5">
                        <div class="col">
                            <div class="row text-secondary">
                                <div class="col-auto"><p class="fs-1 fw-bold lh-sm mb-0">14k+</p></div>
                                <div class="col"><p class="text-uppercase lh-sm mb-0">Variedad de productos</p></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row text-secondary">
                                <div class="col-auto"><p class="fs-1 fw-bold lh-sm mb-0">50k+</p></div>
                                <div class="col"><p class="text-uppercase lh-sm mb-0">Clientes satisfechos</p></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row text-secondary">
                                <div class="col-auto"><p class="fs-1 fw-bold lh-sm mb-0">10+</p></div>
                                <div class="col"><p class="text-uppercase lh-sm mb-0">Distribuidores</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--categorias-->
    <div class="container text-center my-5">
        <h2 class="font-weight-light">Categorias</h2>
        <div class="row mx-auto my-auto justify-content-center">
            <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-img">
                                    <img src="assets/img/categoria_tazas.jpg" class="rounded-circle mg-fluid"  height="200">
                                </div>
                                <p class="card-text mt-3">Tazas</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-img">
                                    <img src="assets/img/categoria_playeras.jpg" class="rounded-circle mg-fluid"  height="200">
                                </div>
                                <p class="card-text mt-3">Playeras</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-img">
                                    <img src="assets/img/categoria_estampas.jpg" class="rounded-circle mg-fluid"  height="200">
                                </div>
                                <p class="card-text mt-3">Calcomanias</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-img">
                                    <img src="assets/img/categoria_gorras.jpg" class="rounded-circle "  width="200">
                                </div>
                                <p class="card-text mt-3">Gorras</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-img">
                                    <img src="assets/img/categoria_libros.jpg" class="rounded-circle "  width="200">
                                </div>
                                <p class="card-text mt-3">Libros</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-img">
                                    <img src="assets/img/categoria_peluches.jpg" class="rounded-circle "  width="200">
                                </div>
                                <p class="card-text mt-3">Peluches</p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active">
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-img">
                                    <img src="assets/img/categoria_varios.jpg" class="rounded-circle "  width="200">
                                </div>
                                <p class="card-text mt-3">Varios</p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>

<?php
include '../resources/templates/footer.html';
include '../resources/templates/scripts.html';
?>
    <script>
        let items = document.querySelectorAll('.carousel .carousel-item')

        items.forEach((el) => {
            const minPerSlide = 4
            let next = el.nextElementSibling
            for (var i=1; i<minPerSlide; i++) {
                if (!next) {
                    // wrap carousel by using first child
                    next = items[0]
                }
                let cloneChild = next.cloneNode(true)
                el.appendChild(cloneChild.children[0])
                next = next.nextElementSibling
            }
        })
    </script>
<?php
include '../resources/templates/fin.html';
