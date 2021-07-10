<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <title>Concurso</title>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.svg"/>

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
                        <h3 class="mb-20">Concursa por grandes premios</h3>
                        <p>Ingresa tu numero de cedula y participa para ganar increíbles premios.</p>
                    </div>
                    <div class="image">
                        <img src="/assets/img/concurso/login.jpg" alt="" class="w-100">
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
                        <div class="alert alert-info" role="alert" style="color: white">{{ $errors->first('email')
                            }}
                        </div>
                        @endif
                        @if ($errors->has('document'))
                        <div class="alert alert-info" role="alert" style="color: white">
                            {{ $errors->first('document') }}
                        </div>
                        @endif
                        @csrf
                        <div class="single-input">
                            <label htmlFor="signup-password">Cedula</label>
                            <input type="number" id="signup-password" name="document"
                                   placeholder="Ingrese cedula">
                            <input type="hidden" name="password" value="password">
                        </div>
                        <div class="form-check mb-25">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" htmlFor="flexCheckDefault">
                                Acepto los términos y la política.
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
