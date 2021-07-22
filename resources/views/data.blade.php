<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <title>Concurso :)</title>
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

    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
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
    <section class="mb-80">
        <div id="app">

            <div class="row g-3">
                <div class="col-auto">
                    <input type="text" class="form-control" id="current" placeholder="Num" v-model="turn.winner">
                </div>
                <div class="col-auto">
                    <button type="button" @click="setTurn" class="btn btn-primary mb-3">Cambiar</button>
                </div>
            </div>

            <hr>
            <div>
                <h4>Turno</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Num</th>
                        <th scope="col">Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr   >
                        <th scope="row">@{{ turn.id }}</th>
                        <td>@{{ turn.winner }}</td>
                        <td>@{{ turn.updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <hr>
            <div>
                <h4>Win</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">validar</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr  v-for="winner in winners">
                        <th scope="row">@{{ winner.id }}</th>
                        <td>@{{ winner.verify }}</td>
                        <td>@{{ winner.user.name }}</td>
                        <td>@{{ winner.updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <hr>

            <div>
                <h4>Participa</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">turn</th>
                        <th scope="col">win</th>
                        <th scope="col">Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr  v-for="participant in participants">
                        <th scope="row">@{{ participant.id }}</th>
                        <td>@{{ participant.user.name }}</td>
                        <td>@{{ participant.turn }}</td>
                        <td>@{{ participant.winner }}</td>
                        <td>@{{ participant.created_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    <script>


        const AttributeBindingApp = {
            data() {
                return {
                    winners: null,
                    turn: {},
                    winner: null,
                    participants: null,

                }
            },
            created() {
                setInterval(() => {  this.getParticipants();  }, 20000)
                setInterval(() => {  this.getWinners();  }, 20000)
            },
            mounted() {
                this.getWinners();
                this.getTurn();
                this.getParticipants();
            },
            methods: {
                async getWinners(){
                     await axios.get('/niw').then(response => { this.winners = response.data })
                },
                async getTurn(){
                    await axios.get('/nrut').then(response => { this.turn = response.data })
                },
                async getParticipants(){
                    await axios.get('/pants').then(response => { this.participants = response.data})
                },
                async setTurn(){
                    await axios.post('/set', { wn: this.turn.winner }).then(() => { this.getTurn(); toastr.success('Se realizo el cambio', 'Actualizado')  })
                },
            }
        }

        Vue.createApp(AttributeBindingApp).mount('#app')

    </script>

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
