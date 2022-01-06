<template>
    <div>
        <div class="control">
            <b-field label="Trouver un département">
                <b-autocomplete
                    :data="departments"
                    field="search"
                    v-model="query"
                    placeholder="Savoie, Haute-Savoie ..."
                    :loading="isFetching"
                    @typing="getAsyncData"
                    @select="option => selected = option"
                    addons="true"
                    :open-on-focus="true"
                    type="search"
                    icon="map-marker-alt"
                    :keep-first=false
                    :expanded=true
                    @keyup.enter.native="enter"
                    custom-class="">

                    <template slot-scope="props">
                        <a class="media" href="#">
                            <div class="media-content">
                                {{ props.option.code }} - {{ props.option.nom }}
                            </div>
                        </a>
                    </template>
                </b-autocomplete>
            </b-field>
        </div>
        <div class="block mt-2">
            <h2 class="title is-2" v-if="this.selected">{{ selected.nom }}</h2>
        </div>
    </div>
</template>

<script>
import debounce from 'lodash/debounce'
import * as api from '../city/api/api'
import {EVENT_NAME} from "./utils/utils";

export default {
    name: "Search",
    data() {
        return {
            departments: [],
            selected: null,
            isFetching: false,
            query: '',
        }
    },
    watch: {
        selected: function () {
            api.getCitiesInformations(this.selected.code)
                .then(r => r.json())
                .then(data => {
                    const {cities} = data;
                    const {features} = cities;

                    this.$root.$emit(EVENT_NAME.GET_GEOJSON, features)
                }).catch((error) => {
                throw error
            }).finally(() => {
                this.isFetching = false;
            });
        }
    },
    methods: {
        getAsyncData: debounce(function (query) {
            if (!query.length) {
                this.departments = [];
                return
            }
            this.isFetching = true;
            api.getResults(query)
                .then(r => r.json())
                .then(data => {
                    const {departments} = data;
                    this.departments = departments;
                }).catch((error) => {
                throw error
            }).finally(() => {
                this.isFetching = false;
            });
        }, 1000),
    }
}
</script>

<style scoped>

</style>
