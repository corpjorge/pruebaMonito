<template>
    <div v-if="message" class="alert alert-warning" role="alert" style="padding: 11px; margin: 8px;">
        Error en tus respuestas, intenta de nuevo
        <button @click="close" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            <div class="form-check">
                <input class="form-check-input" type="radio" :id="question.id+'_'+question.choices.a" :value="question.id+'_a'" :name="question.id" v-model="responses['question_'+index]">
                <label class="form-check-label" :for="question.id+'_'+question.choices.a">
                    {{ question.choices.a }}
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" :id="question.id+'_'+question.choices.b" :value="question.id+'_b'" :name="question.id" v-model="responses['question_'+index]">
                <label class="form-check-label" :for="question.id+'_'+question.choices.b">
                    {{ question.choices.b }}
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" :id="question.id+'_'+question.choices.c" :value="question.id+'_c'" :name="question.id" v-model="responses['question_'+index]">
                <label class="form-check-label" :for="question.id+'_'+question.choices.c">
                    {{ question.choices.c }}
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" :id="question.id+'_'+question.choices.d" :value="question.id+'_d'" :name="question.id" v-model="responses['question_'+index]">
                <label class="form-check-label" :for="question.id+'_'+question.choices.d">
                    {{ question.choices.d }}
                </label>
            </div>

        </div>
    </section>

    </template>

    <div v-if="show" class="alert alert-danger" role="alert" style="padding: 11px; margin: 8px;">
        Seleccione todas las opciones
        <button @click="close" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="d-grid gap-2" style="padding: 11px; margin: 8px;">
        <button  @click="sendResponses" class="button button-lg radius-10 btn-block" type="button" >Terminar</button>
    </div>


    <div class="modal fade show" :class="{ modalActive: isActive }" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Felicitaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Has respondido correctamente las respuestas, ahora entra a participar en el sorteo intenta ganar
                </div>
                <div class="modal-footer">
                    <button @click="participate" type="button" class="btn btn-primary btn-group">Ir a participar</button>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import axios from "axios";

export default {
    name: "Questions",
    data(){
        return {
            questions: {},
            responses: {},
            show: false,
            result: null,
            message: false,
            isActive: false,
        }
    },
    created() {
        this.getQuestions()
    },
    methods: {
        getQuestions(){
            axios.get('/questions').then(response => { this.questions =  response.data })
        },
        sendResponses(){
            if (Object.keys(this.responses).length < 3) {
                return this.show = true;
            }
            this.show = false;
            axios.post('/finish', this.responses)
                .then(response => {
                    this.result =  response.data.R

                    if (!this.result){
                        this.getQuestions();
                        this.responses = {};
                        this.message =  true;
                        window.scrollTo(0,0);
                    }

                    if (this.result){ this.isActive = true }
                })
        },
        participate(){
            window.location.assign("/slots")
        },
        close(){ this.show = false; this.message = false }
    }
}
</script>

<style scoped>
.modalActive{
    display: block;
}

</style>
