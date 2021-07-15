<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <title>Concurso</title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/concurso/favicon.ico"/>

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="/assets/css/bootstrap-5.0.0-alpha-2.min.css"/>
    <link rel="stylesheet" href="/assets/css/LineIcons.2.0.css"/>
    <link rel="stylesheet" href="/assets/css/tiny-slider.css"/>
    <link rel="stylesheet" href="/assets/css/glightbox.min.css"/>
    <link rel="stylesheet" href="/assets/css/animate.css"/>
    <link rel="stylesheet" href="/assets/css/lindy-uikit.css"/>
</head>

<body class="antialiased">
<div class="preloader">
    <div class="loader">
        <div class="spinner">
            <div class="spinner-container">
                <div class="spinner-rotator">
                    <div class="spinner-left">
                        <div class="spinner-circle"></div>
                    </div>
                    <div class="spinner-right">
                        <div class="spinner-circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="signup signup-style-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="signup-content-wrapper">
                    <div class="section-title">
                        <h3 class="mb-20">Celebra junto con nosotros nuestro aniversario número 50</h3>
                        <p>Tu eres nuestro invitado especial, ingresa tu número de cédula y participa para ganar increíbles premios.</p>
                    </div>
                    <div class="image">
                        <img src="/assets/img/concurso/login.png" alt="" class="w-100">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="signup-form-wrapper">
                    @if (session('status'))
                    <div class="alert alert-info" role="alert" style="color: white">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="post" action="{{ route('login') }}" class="signup-form">
                        @if ($errors->has('email'))
                        <div class="alert alert-danger" role="alert" style="color: white">{{ $errors->first('email')
                            }}
                        </div>
                        @endif
                        @if ($errors->has('document'))
                        <div class="alert alert-danger" role="alert" style="color: #323450">
                            {{ $errors->first('document') }}
                        </div>
                        @endif

                        @if ($errors->has('condiciones'))
                        <div class="alert alert-danger" role="alert" style="color: #323450">
                            {{ $errors->first('condiciones') }}
                        </div>
                        @endif

                        @csrf
                        <div class="single-input">
                            <label htmlFor="signup-password">Cédula</label>
                            <input type="number" id="signup-password" name="document"
                                   placeholder="Ingrese cédula">
                            <input type="hidden" name="password" value="password">
                        </div>
                        <a href="/assets/FEDEF.pdf" target="_blank">Clic para ver términos y condiciones </a>
                        <div class="form-check mb-25">
                            <input class="form-check-input" type="checkbox" id="agree" name="condiciones">
                            <label class="form-check-label" for="agree">
                                Acepto términos y condiciones.
                            </label>
                        </div>
                        <div class="signup-button mb-25">
                            <button type="submit" class="button button-lg radius-10 btn-block">Participar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="/assets/js/bootstrap.5.0.0.alpha-2-min.js"></script>
<script src="/assets/js/tiny-slider.js"></script>
<script src="/assets/js/count-up.min.js"></script>
<script src="/assets/js/imagesloaded.min.js"></script>
<script src="/assets/js/isotope.min.js"></script>
<script src="/assets/js/glightbox.min.js"></script>
<script src="/assets/js/wow.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>
