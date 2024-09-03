<template>
    <section>
        <b-field label="Find a player">
            <b-autocomplete
                :data="players"
                v-model="query"
                placeholder="Lebron James ..."
                field="title"
                :loading="isFetching"
                @typing="getAsyncData"
                :keep-first=false
                :expanded=true
                @keyup.enter.native="enter"
                @select="option => selected = option">

                <template slot-scope="props">
                    <a class="media" href="#">
                        <div class="media-content">
                            {{ props.option.firstName }} {{ props.option.lastName|upperCase }}
<!--                            ({{ props.option.team.name }})-->
                        </div>
                    </a>
                </template>
            </b-autocomplete>
        </b-field>

        <AddPlayerBox v-if="selected"
                :player="selected"
        ></AddPlayerBox>

        <Players></Players>
    </section>
</template>

<script>
import debounce from 'lodash/debounce'
import * as api from "../basket/api/api";
import Players from "./Players";
import AddPlayerBox from "./player/AddPlayerBox";

export default {
    name: "Basket",
    components: {AddPlayerBox, Players},
    data() {
        return {
            players: [],
            selected: null,
            isFetching: false,
            query: '',
        }
    },
    methods: {
        getAsyncData: debounce(function (query) {
            if (!query.length) {
                this.players = []
                return
            }
            this.isFetching = true;
            api.searchPlayer(query)
                .then(r => r.json())
                .then(data => {
                    const {players} = data;
                    this.players = players;
                    console.log(this.players)
                }).catch((error) => {
                throw error
            }).finally(() => {
                this.isFetching = false;
            });
        }, 500),
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