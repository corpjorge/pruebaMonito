<template>
    <section id="about" class="about-section about-style-1">
        <div class="container">
            <div class="row">
                <div class="walk-container" id="walk-container-one">
                    <div><img src="/assets/img/concurso/reel.png" alt="img"/></div>
                </div>
                <div class="walk-container" id="walk-container-two">
                    <div> <img src="/assets/img/concurso/reel.png" alt="img"/></div>
                </div>
                <div class="walk-container" id="walk-container-three">
                    <div> <img src="/assets/img/concurso/reel.png" alt="img"/></div>
                </div>
            </div>
        </div>
        <div class="about-image">
            <button @click="run" class="btn bg-danger">Girar</button>
        </div>
    </section>

</template>

<script>
export default {
    name: "List",
    methods: {
        run() {

            const one = document.getElementById('walk-container-one');
            const two = document.getElementById('walk-container-two');
            const three = document.getElementById('walk-container-three');

            one.classList.add('walk-container-one');
            one.classList.add('walk-container-one-finalized');

            two.classList.add('walk-container-two');
            two.classList.add('walk-container-two-finalized');

            three.classList.add('walk-container-three');
            three.classList.add('walk-container-three-finalized');
        }
    }
}
</script>

<style scoped>
.walk-container {
    display: inline-block;
    position: relative;
    width: 13%;
    vertical-align: middle;
}

.walk-container > div {
    display: inline-block;
    position: absolute;
    top: 0;
    left: 0;
    width: 128px;
    height: 202px;
    background: url('/assets/img/concurso/icons.png') repeat-y;
    background-position-x: 9px;
}

.walk-container-one > div {
    background-position-y: -5px;
    animation: one ease 10s normal;
}

.walk-container-one-finalized > div {
    background-position-y: -11220px;
}

.walk-container-two > div {
    background-position-y: -315px;
    animation: two ease 8s normal;
}

.walk-container-two-finalized > div {
    background-position-y: -10220px;
}

.walk-container-three > div {
    background-position-y: -435px;
    animation: three ease 6s normal;
}

.walk-container-three-finalized > div {
    background-position-y: -18220px;
}

@keyframes one {
    from { background-position-y: 5px }
    to { background-position-y: -11220px }
    /*100% {background-position-y: -11220px}*/
}

@keyframes two {
    from { background-position-y: 5px }
    to { background-position-y: -10220px }
}

@keyframes three {
    from { background-position-y: 5px }
    to { background-position-y: -18220px }
}

</style>
