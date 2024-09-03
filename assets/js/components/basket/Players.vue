<template>
    <section class="section">
        <h2 class="title is-2"> Mes joueurs</h2>
        <div class="columns is-multiline">
            <PlayerCard v-for="player in players" :player="player" class="column is-one-quarter"></PlayerCard>
        </div>
    </section>
</template>

<script>
import * as api from "../basket/api/api";
import PlayerCard from './player/PlayerCard'

export default {
    name: "Players",
    components: {PlayerCard},
    data() {
        return {
            players: [],
            isFetching: false
        }
    },
    mounted() {
        this.getPlayers();
    },
    methods:
        {
            getPlayers: function () {
                this.isFetching = true;
                api.getPlayers()
                    .then(r => r.json())
                    .then(players => {
                        this.players = players;
                    }).catch((error) => {
                    throw error
                }).finally(() => {
                    this.isFetching = false;
                });
            }
        }
}
</script>

<style scoped>

</style>