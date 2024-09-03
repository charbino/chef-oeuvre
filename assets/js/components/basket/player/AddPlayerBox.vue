<template>
    <div class="box">
        <article class="media">
            <div class="media-content">
                <Player :player="player"></Player>
                <button v-if='displayBtnAdd' class="button is-link" :class="{'is-loading':isAdding}"
                        @click="addPlayer()">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span>Ajouter</span>
                </button>
            </div>
        </article>
    </div>
</template>

<script>
import * as api from "../api/api";

import Player from './Player'

export default {
    name: "AddPlayerBox",
    props: ['player'],
    components: {Player},
    data() {
        return {
            isAdding: false,
            displayBtnAdd: true
        }
    },
    methods: {
        displayHeight() {
            return this.player.height / 100 + ' m'
        },
        displayWeight() {
            return this.player.weight + ' Kg';
        },
        addPlayer() {
            this.isAdding = true;
            api.addPlayer(this.player)
                .then(r => r.json())
                .then(data => {
                    this.displayBtnAdd = false;
                    this.$buefy.toast.open({
                        message: 'Le joueur a bien été ajouté à la base de donnée',
                        type: 'is-success'
                    })
                }).catch((error) => {
                throw error
            }).finally(() => {
                this.isAdding = false;
            });
        }
    }
}
</script>

<style scoped>

</style>