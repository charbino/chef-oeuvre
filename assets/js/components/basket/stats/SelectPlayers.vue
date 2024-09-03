<template>
    <div class="box">
        <div>
            <p class="title is-4">
                <span class="title-button-static">2</span>
                Choisir les joueurs
            </p>
        </div>
        <SearchPlayer></SearchPlayer>

        <div>
            <div class="columns is-multiline">
                <PlayerCardStat v-for="player in players" :player="player" class="column is-one-quarter"></PlayerCardStat>
            </div>
        </div>
    </div>
</template>

<script>
import {EVENT_NAME} from "../utils/utils";
import SearchPlayer from "../SearchPlayer.vue";
import PlayerCardStat from "../player/PlayerCardStat.vue";
import useFetchStatsPlayers from "../module/fetch-stat-players";
import Graphics from "./Graphics.vue";

export default {
    name: "SelectPlayers",
    components: {Graphics, PlayerCardStat, SearchPlayer},
    data() {
        return {
            players: [],
            isFetching: false
        }
    },
    mounted() {
        this.$root.$on(EVENT_NAME.ADD_PLAYER, (player) => {
            this.players.push(player)
            useFetchStatsPlayers().addPlayer(player)
        })
    }
}
</script>

<style scoped>

</style>