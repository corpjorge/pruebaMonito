<template>
    <section id="about" class="about-section about-style-1" style="background: #e2e2e2; padding: 100px 0 140px;">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 offset-xl-7 col-lg-6 offset-lg-6">
                    <div class="about-content-wrapper">
                        <div class="section-title">
                            <h3 class="mb-25 wow fadeInUp" data-wow-delay=".2s">¿Cómo participar? </h3>
                            <p class="mb-30 wow fadeInUp" data-wow-delay=".4s">
                                Responde las preguntas de manera correcta y participa girando la máquina de premios. Ganaras cuando se alineen nuestros logos.
                            </p>
                        </div>
                        <div class="content">
                            <div class="single-item">
                                <div class="icon">
                                    <i class="lni lni-pencil-alt"></i>
                                </div>
                                <div class="text">
                                    <h6 class="mb-10">Preguntas</h6>
                                    <p>Selecciona la respuesta correcta en cada pregunta.</p>
                                </div>
                            </div>
                            <div class="single-item">
                                <div class="icon">
                                    <i class="lni lni-medall"></i>
                                </div>
                                <div class="text">
                                    <h6 class="mb-10">Concurso</h6>
                                    <p>Gira la máquina de premios y prueba tu suerte.</p>
                                </div>
                            </div>

                            <button @click="next" class="button button-lg radius-10 btn-block" type="button" style="cursor: pointer;">¡Empezar a Jugar!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-image" style="height: 100%;">
            <img src="assets/img/concurso/lista.png" alt="">
        </div>
    </section>

</template>

<script>
export default {
    name: "List",
    methods: {
        next(){
            this.$router.push({ name: 'Questions' })
        }
    }
}
</script>

<style scoped>

</style>
