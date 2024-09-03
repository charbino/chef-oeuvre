<template>
    <div>
        <div class="card">
            <div class="card-content">
                <Player :player="player"></Player>
            </div>
            <footer class="card-footer">
                <a href="#" class="card-footer-item">
                    <span class="icon-text has-text-danger">
                        <span class="icon">
                            <i class="fas fa-trash"></i>
                        </span>
                        <span>Supprimer</span>
                    </span>
                </a>
            </footer>
        </div>
    </div>
</template>

<script>
import * as api from "../api/api";

import Player from './Player'

export default {
    name: "PlayerCard",
    props: ['player'],
    components: {Player},
    data() {
        return {
            // isAdding: false,
            // displayBtnAdd: true
        }
    },
    methods: {
        // addPlayer() {
        //     this.isAdding = true;
        //     api.addPlayer(this.player)
        //         .then(r => r.json())
        //         .then(data => {
        //             this.displayBtnAdd = false;
        //             this.$buefy.toast.open({
        //                 message: 'Le joueur a bien été ajouté à la base de donnée',
        //                 type: 'is-success'
        //             })
        //         }).catch((error) => {
        //         throw error
        //     }).finally(() => {
        //         this.isAdding = false;
        //     });
        // }
    }
}
</script>

<style scoped>

</style>