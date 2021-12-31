<template>

    <nav class="level">
        <div class="level-item has-text-centered">
            <div>
                <p class="heading">Synchronisation</p>
                <p class="title">Toutes les {{delais}}s</p>
            </div>
        </div>
        <!--            <div class="level-item has-text-centered">-->
        <!--                <div>-->
        <!--                    <p class="heading">Localistation</p>-->
        <!--                    <p class="title">{{localistation}}</p>-->
        <!--                </div>-->
        <!--            </div>-->
        <div class="level-item has-text-centered">
            <div>
                <p class="heading">Altitude</p>
                <p class="title">{{altitude | number }} Km</p>
            </div>
        </div>
        <div class="level-item has-text-centered">
            <div>
                <p class="heading">Vitesse</p>
                <p class="title">{{speed | number }} {{units}}</p>
            </div>
        </div>
    </nav>
</template>


<script>
export default {
    name: "Header",
    props:{
        delais: Number,
        altitude: Number,
        localistation: String,
        speed: Number,
        units: String
    },
    filters:{
        number : function(value){
            return Math.round(value*100)/100;
        }
    }

}
</script>

<style scoped>

</style>
