<template>
    <section id="about" class="about-section about-style-1">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 offset-xl-7 col-lg-6 offset-lg-6">
                    <div class="about-content-wrapper">
                        <div class="section-title">
                            <h3 class="mb-25 wow fadeInUp" data-wow-delay=".2s">Como participar</h3>
                            <p class="mb-30 wow fadeInUp" data-wow-delay=".4s">
                                Responde las preguntas de manera correcta y participa en girar el reel y lograr completar los 3 logos de para ganar.
                            </p>
                        </div>
                        <div class="content">
                            <div class="single-item">
                                <div class="icon">
                                    <i class="lni lni-pencil-alt"></i>
                                </div>
                                <div class="text">
                                    <h6 class="mb-10">Encuesta</h6>
                                    <p>Responde las preguntas de manera correcta. </p>
                                </div>
                            </div>
                            <div class="single-item">
                                <div class="icon">
                                    <i class="lni lni-medall"></i>
                                </div>
                                <div class="text">
                                    <h6 class="mb-10">Concurso</h6>
                                    <p>3 oportunidades para gira y lograr los tres logos ganadores.</p>
                                </div>
                            </div>

                            <a @click="next" class="read-more-button" style="cursor: pointer;">Comenzar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-image">
<!--            <img src="assets/img/about/about-1/about-img-1.jpg" alt="">-->
            <img src="assets/img/about/about-1/about-img-1.jpg" alt="">
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
