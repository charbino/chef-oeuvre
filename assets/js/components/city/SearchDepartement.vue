<template>
    <div class="control mb-1">
        <b-field label="Trouver un département">
            <b-autocomplete
                :data="department"
                field="search"
                v-model="query"
                placeholder="13, 73, Savoie, Haute-Savoie ..."
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
        <div class="content" v-if="this.selected">
            <span class="title is-5"> Departement : </span> <span> {{ selected.nom }} </span>
            <!--                <ul>-->
            <!--                    <li v-for="(city,index) in citiesSelected" :key="index">-->
            <!--                        <span class="icon-text">-->
            <!--                            <span>{{ city.properties.code_insee }} - {{ city.properties.nom_com }}</span>-->
            <!--                            <span class="icon" @click="removeCity(city)"> <i class="fas fa-times"></i></span>-->
            <!--                        </span>-->
            <!--                    </li>-->
            <!--                </ul>-->
        </div>

    </div>
</template>

<script>
import debounce from 'lodash/debounce'
import * as api from '../city/api/api'
import {EVENT_NAME} from "./utils/utils";

export default {
    name: "SearchDepartement",
    data() {
        return {
            department: [],
            selected: null,
            isFetching: false,
            query: '',
        }
    },
    watch: {
        selected: function () {
            api.getCitiesFromDepartement(this.selected.code)
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
                this.department = [];
                return
            }
            this.isFetching = true;
            api.getResults(query)
                .then(r => r.json())
                .then(data => {
                    const {departments} = data;
                    this.department = departments;
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
