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
    name: "PlayerCardStat",
    props: ['player'],
    components: {Player},
    data() {
        return {

        }
    },
    methods: {

    }
}
</script>

<style scoped>

</style>