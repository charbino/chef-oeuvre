<template>
    <div class="content">
        <p>
            <strong>{{ player.firstName }} {{ player.lastName|upperCase }}</strong>
            <br>
        </p>
        <p>
            Position : {{ player.position }}<br>
            Taille : {{ displayHeight() }}<br>
            Poids : {{ displayWeight() }}
        </p>
        <span class="tag is-primary is-medium">{{ player.team.name }}</span>
    </div>
</template>

<script>
import * as api from "../api/api";

export default {
    name: "Player",
    props: ['player'],
    data() {
        return {
            isAdding: false,
            displayBtnAdd: true
        }
    },
    mounted() {
        console.log(this.player);
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
    },
    filters: {
        upperCase: function (value) {
            if (!value) return ''
            value = value.toString()

            return value.toUpperCase();
        }
    }
}
</script>

<style scoped>

</style>