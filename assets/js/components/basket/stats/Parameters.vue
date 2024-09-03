<template>
    <div class="box has-background-link">
        <div>
            <p class="title is-4 has-text-white-bis">
                <span class="title-button-static">1</span>
                Définir les paramètres
            </p>
        </div>
        <b-field label="Season" type="is-info" custom-class="has-text-white-bis">
            <b-slider v-model="seasons" :min="seasonMin" :max="seasonMax" :step="1" type="is-white" ticks >
            </b-slider>
        </b-field>
    </div>
</template>

<script>
import useFetchStatsPlayers from "../module/fetch-stat-players";
import {EVENT_NAME} from "../utils/utils";

export default {
    name: "Parameters",
    data() {
        return {
            seasonMin: 1979,
            seasonMax: 2022,
            seasons: [2019, 2020]
        }
    },
    watch: {
        seasons(newsSeasons, oldSeasons) {

            if(newsSeasons.length === 0){
                return
            }

            let season = newsSeasons[0];
            let seasons = [];
            while (season <= newsSeasons[1]){
                seasons.push(season);
                season++;
            }

            useFetchStatsPlayers().setSeasons(seasons);
            this.$root.$emit(EVENT_NAME.CHANGE_PARAMETERS_SEASONS, seasons)
        }
    },
}
</script>

<style scoped>

</style>