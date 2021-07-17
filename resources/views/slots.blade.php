<!DOCTYPE html>
<html class="no-js" lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="x-ua-compatible" content="ie=edge"/>
        <title>Concurso</title>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="shortcut icon" type="image/x-icon" href="/assets/img/concurso/favicon.ico"/>
        <link rel="stylesheet" href="/assets/css/bootstrap-5.0.0-alpha-2.min.css"/>
        <link rel="stylesheet" href="/assets/css/LineIcons.2.0.css"/>
        <link rel="stylesheet" href="/assets/css/tiny-slider.css"/>
        <link rel="stylesheet" href="/assets/css/glightbox.min.css"/>
        <link rel="stylesheet" href="/assets/css/animate.css"/>
        <link rel="stylesheet" href="/assets/css/lindy-uikit.css"/>
        <link rel="stylesheet" href="/assets/css/slots.css"/>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <style>
            body {
                margin: 0;
                background-repeat: no-repeat;
                background-color: #004679;
            }

            .walk-container {
                display: inline-block;
                position: relative;
                vertical-align: middle;
            }

            .walk-container > div {
                display: inline-block;
                position: absolute;
                background: url('/assets/img/concurso/icons1.png') repeat-y;
                background-position-x: 9px;
                opacity: 0.7;
            }

            .walk-container-one > div {
                background-position-y: -5px;
                animation: one ease 10s normal;
            }

            .walk-container-one-finalized > div {
                background-position-y: {{$one}}px;
            }

            .walk-container-two > div {
                background-position-y: -315px;
                animation: two ease 8s normal;
            }

            .walk-container-two-finalized > div {
                background-position-y: {{$two}}px;
            }

            .walk-container-three > div {
                background-position-y: -435px;
                animation: three ease 6s normal;
            }

            .walk-container-three-finalized > div {
                background-position-y: {{$three}}px;
            }

            @keyframes one {
                from { background-position-y: 5px }
                to { background-position-y: {{$one}}px }
            }

            @keyframes two {
                from { background-position-y: 5px }
                to { background-position-y: {{$two}}px }
            }

            @keyframes three {
                from { background-position-y: 5px }
                to { background-position-y: {{$three}}px }
            }

            .centro {
                height: 150px;
                display: flex;
                justify-content: center;
                align-items: center;
                margin-top: 9%;
            }

            #myVideo {
                position: fixed;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
            }

            .front {
                transition:
                    transform
                    600ms
                    cubic-bezier(.3, .7, .4, 1);
            }

            .pushable:hover .front {
                transform: translateY(-6px);
                transition:
                    transform
                    250ms
                    cubic-bezier(.3, .7, .4, 1.5);
            }

            .pushable:active .front {
                transform: translateY(-2px);
                transition: transform 34ms;
            }

            .pushable {
                background: hsl(345deg 100% 18%);
                border: none;
                border-radius: 57px;
                padding: 0;
                cursor: pointer;
            }

            .front {
                display: block;
                padding: 12px 42px;
                border-radius: 57px;;
                font-size: 1.25rem;
                background: hsl(323deg 100% 44%);;
                color: white;
                transform: translateY(-4px);
            }

            .pushable:active .front {
                transform: translateY(-2px);
            }

            .pushable:focus:not(:focus-visible) {
                outline: none;
            }

            .lost {
                text-align: center;
                background-color: #91ed6d4a;
                max-width: 293px;
                padding: 5px;
                margin-top: 22%;
            }
        </style>
    </head>
    <body>

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

    <div class="centro">
        <div class="walk-container" id="walk-container-one">
            <div></div>
        </div>
        <div class="walk-container" id="walk-container-two">
            <div></div>
        </div>
        <div class="walk-container" id="walk-container-three">
            <div></div>
        </div>
    </div>

    <div class="centro" style="margin-top: 0%;">
        <button onclick="run()" class="pushable radius-50" id="girar" style="margin-top: 168px;">
            <span class="front">
                Comenzar a Girar
            </span>
        </button>
    </div>


    @if($win)
    <a href=" {{ url('/congratulations') }} ">
        <div class="modal fade show" id="lost" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-modal="true" role="dialog">
            <div class="modal-dialog lost" style="text-align: center;">
                <img src="/assets/img/concurso/win.png" style="width: 282px;" alt="win">
            </div>
        </div>
    </a>
    @else
    <a href=" {{ url('/close') }} ">
        <div class="modal fade show" id="lost" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-modal="true" role="dialog">
            <div class="modal-dialog lost" style="text-align: center;">
                <img src="/assets/img/concurso/lose.png" style="width: 282px;" alt="Perdiste">
            </div>
        </div>
    </a>
    @endif

    <script>
        function run() {

            const music = new Audio('/assets/img/concurso/cancion3.mp3');
            music.play();
            music.volume = 0.2;

            const one = document.getElementById('walk-container-one');
            const two = document.getElementById('walk-container-two');
            const three = document.getElementById('walk-container-three');
            document.getElementById('girar').style.display = "none";

            one.classList.add('walk-container-one');
            one.classList.add('walk-container-one-finalized');

            two.classList.add('walk-container-two');
            two.classList.add('walk-container-two-finalized');

            three.classList.add('walk-container-three');
            three.classList.add('walk-container-three-finalized');

            setTimeout(function(){
                axios.post('/run', { he: <?php echo $turn ?> });
                const lost = document.getElementById('lost').style.display = "block";
            }, 10000);

            setTimeout(function(){
                axios.post('/verify', { he: <?php echo $turn ?> });
                axios.post('/logout');
                const lost = document.getElementById('lost').style.display = "block";
            }, 13000);
        }
    </script>

    <script src="/assets/js/wow.min.js"></script>
    <script src="/assets/js/main.js"></script>
    </body>
</html>
