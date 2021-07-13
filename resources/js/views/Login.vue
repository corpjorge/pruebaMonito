<template>
    <section class="signup signup-style-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="signup-content-wrapper">
                        <div class="section-title">
                            <h3 class="mb-20">Concursa por grandes premios</h3>
                            <p>Ingresa tu número  de cédula y participa para ganar increíbles premios.</p>
                        </div>
                        <div class="image">
                            <img src="/assets/img/concurso/login.png" alt="" class="w-100">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                    <div v-if="errors.document" class="alert alert-danger" role="alert">
                        {{ errors.document[0] }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div v-if="show === 'Too Many Attempts.'" class="alert alert-danger" role="alert">
                        {{ attempts }}
                        <button @click="close" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="signup-form-wrapper">
                        <div class="signup-form">
                            <div class="single-input">
                                <label htmlFor="signup-password">Cédula</label>
                                <input type="number" id="signup-password" name="signup-password"
                                       placeholder="Ingresa cedula" v-model="document">
                            </div>
                            <div class="form-check mb-25">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" htmlFor="flexCheckDefault">
                                    Acepto los términos y la política.
                                </label>
                            </div>
                            <div class="signup-button mb-25">
                                <button @click="login" class="button button-lg radius-10 btn-block">Participar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";

export default {
    name: "Login",
    data() {
        return {
            document: null,
            errors: {},
            show: false,
            attempts: 'Demasiados intentos.'
        }
    },
    methods: {
        login(){
            axios.post('/login', { document: this.document, password: '123' })
                .then(response => {
                    // this.$router.push({ name: 'List' })
                    window.location.assign("/#/list")
                })
                .catch(errors => {
                    this.show = errors.response.data.message ?? null;
                    if (this.show === 'Too Many Attempts.'){ return }
                    this.errors = errors.response.data.errors ?? null;
                })
        },
        close(){
            this.show = false
        }
    }
}
</script>

<style scoped>

</style>
