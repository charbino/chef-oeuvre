<template>
    <section>
        <h1>Players Comparator Man</h1>
        <p><a href="https://app.balldontlie.io/dashboards/113?graphId=60">Exemple Utilisation</a></p>
        <Parameters></Parameters>
        <SelectPlayers></SelectPlayers>
        <Graphics></Graphics>
    </section>
</template>

<script>
import SearchPlayer from "./SearchPlayer";
import PlayerCardStat from "./player/PlayerCardStat";
import Parameters from "./stats/Parameters.vue";
import SelectPlayers from "./stats/SelectPlayers.vue";
import {EVENT_NAME} from "./utils/utils";
import useFetchStatsPlayers from "./module/fetch-stat-players";
import Graphics from "./stats/Graphics.vue";

export default {
    name: "PlayersComparator",
    components: {Graphics, SelectPlayers, Parameters, SearchPlayer, PlayerCardStat},
    data() {
        return {
            seasonMin: 1979,
            seasonMax: 2022,
            seasons: [2019, 2020],
            players: [],
            isFetching: false
        }
    },
    mounted() {
        this.$root.$on(EVENT_NAME.ADD_PLAYER, (player) => {
            console.log(player);
            useFetchStatsPlayers().updateStats();
        });
        this.$root.$on(EVENT_NAME.CHANGE_PARAMETERS_SEASONS, (seasons) => {
            useFetchStatsPlayers().updateStats();
        });
    },
    methods: {
        getStatsParameter() {
            return {
                'seasons': this.seasons
            }
        }
    },
}
</script>

<style scoped>

</style>