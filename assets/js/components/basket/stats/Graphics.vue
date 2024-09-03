<template>
    <div>
        <Bar
            id="my-chart-id"
            v-if="getData().loaded"
            :options="chartOptions"
            :data="getData()"
        />
    </div>
</template>

<script>
import {Bar} from 'vue-chartjs'
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js'
import useFetchStatsPlayers from "../module/fetch-stat-players";
import {EVENT_NAME} from "../utils/utils";

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: "Graphics",
    components: {Bar},
    setup() {
        const {getStatPlayers, getGraphicStatPlayer} = useFetchStatsPlayers();

        console.log(getStatPlayers())
        return {
            graphic: getGraphicStatPlayer()
        }
    },
    mounted() {
        // this.$root.$on(EVENT_NAME.UPDATE_STAT, () => {
        //     console.log(useFetchStatsPlayers().getStatPlayers());
        // });
    },
    data() {

        return {
        //     loaded: false,
        //     chartData: this.getGraphicStatPlayer(),
            chartOptions: {
                responsive: true
            }
        }
    },
    methods:{
        getData(){
          return this.graphic;
        },
    }
}
</script>

<style scoped>

</style>