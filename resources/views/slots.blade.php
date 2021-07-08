<!DOCTYPE html>
<html class="no-js" lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="x-ua-compatible" content="ie=edge"/>
        <title>Concurso</title>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.svg"/>
        <style>
            body {
                line-height: 1;
                color: black;
                background: black;
                font-family: Lucida Grande, trebuchet ms, verdana, arial, helvetica, sans-serif;
            }

            #viewport {
                overflow: hidden;
                width: 100%;
                display: block;
            }

            #viewport.mobile {
                position: absolute;
                top: 0;
                left: 0;
            }

            #viewport.tablet {
                position: absolute;
                top: 0;
                left: 0;
            }

            #viewport.desktop {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
            }

            #content {
                position: absolute;
                width: 550px;
                height: 430px;
                left: 50%;
                top: 100px;
                margin-left: -275px;
            }

            canvas {
                -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
                -webkit-touch-callout: none;
                -webkit-user-select: none;
            }
        </style>
    </head>
    <body>
        <div id="viewport">
            <div id="content">
                <div id="game">
                    <canvas id="slots" width="550" height="430"></canvas>
                </div>
            </div>
        </div>
        <script src="/assets/js/slots.js"></script>
    </body>
</html>
