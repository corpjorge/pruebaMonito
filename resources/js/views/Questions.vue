<template>
    <div class="container">
        <img src="assets/img/concurso/banner.jpg" alt="" style="width: 100%;"/>
        <div class="p-4 p-md-5 mb-4 text-white  bg-dark">
            <div class="col px-0">
                <p class="lead" style="font-size: 2.25rem; font-weight: 400; line-height: 38px;"> Responde de manera correcta las preguntas para poder participar en el sorteo.</p>
                <p>*Recuerda que si no conoces alguna de las respuestas podrás encontrarlas navegando nuestra pagina WEB</p>
            </div>
        </div>

        <template v-for="(question, index) in questions">
            <section class="pricing-section pricing-style-1 mb-80">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-10">
                            <div class="section-title text-center mb-60">
                                <p>{{ question.title }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                    <div class="col-6 themed-grid-col">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" :id="question.id+'_'+question.choices.a"
                                   :value="question.id+'_a'" :name="question.id" v-model="responses['question_'+index]">
                            <label class="form-check-label" :for="question.id+'_'+question.choices.a">
                                {{ question.choices.a ? question.choices.a : '' }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" :id="question.id+'_'+question.choices.b"
                                   :value="question.id+'_b'" :name="question.id" v-model="responses['question_'+index]">
                            <label class="form-check-label" :for="question.id+'_'+question.choices.b">
                                {{ question.choices.b }}
                            </label>
                        </div>
                    </div>
                    <div class="col-6 themed-grid-col">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" :id="question.id+'_'+question.choices.c"
                                   :value="question.id+'_c'" :name="question.id" v-model="responses['question_'+index]">
                            <label class="form-check-label" :for="question.id+'_'+question.choices.c">
                                {{ question.choices.c }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" :id="question.id+'_'+question.choices.d"
                                   :value="question.id+'_d'" :name="question.id" v-model="responses['question_'+index]">
                            <label class="form-check-label" :for="question.id+'_'+question.choices.d">
                                {{ question.choices.d }}
                            </label>
                        </div>
                    </div>
                    </div>
                </div>
            </section>

        </template>

        <div v-if="show" class="alert alert-danger" role="alert" style="padding: 11px; margin: 8px;">
            Seleccione todas las opciones
            <button @click="close" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="d-grid gap-2" style="padding: 11px; margin: 8px;">
            <button @click="sendResponses" class="button button-lg radius-10 btn-block" type="button">Terminar</button>
        </div>


        <div class="modal fade show slide-in-top" :class="{ modalActive: isActive }" id="exampleModal" tabindex="-1"
             aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert alert-success">
                        <h5 class="modal-title" id="exampleModalLabel">Felicitaciones</h5>
                    </div>
                    <div class="modal-body">
                        Has respondido correctamente las preguntas, ahora entra a participar en el sorteo e intenta ganar
                    </div>
                    <div class="modal-footer">
                        <button @click="participate" type="button" class="btn btn-success btn-group">Ir a participar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade show slide-in-top-lost" :class="{ modalActive: isActive_lost }" id="Modal" tabindex="-1"
             aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert alert-danger">
                        <h5 class="modal-title" id="exampleModalLabel">Incorrecto</h5>
                    </div>
                    <div class="modal-body" style="color: #862828">
                        Error en tus respuestas, intenta de nuevo
                    </div>
                    <div class="modal-footer">
                        <button @click="close" type="button" class="btn btn-primary btn-group">Volver a intentarlo
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


</template>

<script>
import axios from "axios";

export default {
    name: "Questions",
    data() {
        return {
            questions: {},
            responses: {},
            show: false,
            result: null,
            isActive: false,
            isActive_lost: false
        }
    },
    created() {
        this.getQuestions()
    },
    methods: {
        getQuestions() {
            axios.get('/questions').then(response => {
                this.questions = response.data
            })
        },
        sendResponses() {
            if (Object.keys(this.responses).length < 3) {
                return this.show = true;
            }
            this.show = false;
            axios.post('/finish', this.responses)
                .then(response => {
                    this.result = response.data.R

                    if (!this.result) {
                        this.getQuestions();
                        this.responses = {};
                        this.isActive_lost = true;
                        window.scrollTo(0, 0);
                    }

                    if (this.result) {
                        this.isActive = true
                    }
                })
        },
        participate() {
            window.location.assign("/slots")
        },
        close() {
            this.show = false;
            this.isActive_lost = false
        }
    }
}
</script>

<style scoped>
.modalActive {
    display: block;
}

.slide-in-top {
    background-color: #0000005e;
    -webkit-animation: slide-in-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
    animation: slide-in-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
}

.slide-in-top-lost {
    background-color: #0000005e;
    -webkit-animation: slide-in-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
    animation: slide-in-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
}

@-webkit-keyframes slide-in-top {
    0% {
        -webkit-transform: translateY(-1000px);
        transform: translateY(-1000px);
        opacity: 0;
    }
    100% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        opacity: 1;
    }
}
@keyframes slide-in-top {
    0% {
        -webkit-transform: translateY(-1000px);
        transform: translateY(-1000px);
        opacity: 0;
    }
    100% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
        opacity: 1;
    }
}


@media only screen and (max-width: 600px) {
    .col-6 {
        width: 100%;
    }
}


</style>
