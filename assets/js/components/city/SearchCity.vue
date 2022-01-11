<template>
    <div class="control">
        <b-field label="Trouver une commune">
            <b-autocomplete
                :data="cities"
                field="search"
                v-model="query"
                placeholder="Paris, Lyon, Marseille ..."
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
                            {{ props.option.codesPostaux[0] }} - {{ props.option.nom }}
                        </div>
                    </a>
                </template>
            </b-autocomplete>
        </b-field>
        <div class="content" v-if="citiesSelected.length > 0">
            <span class="title is-5"> Communes </span>
            <ul>
                <li v-for="(city,index) in citiesSelected" :key="index">
                        <span class="icon-text">
                            <span>{{ city.properties.code_insee }} - {{ city.properties.nom_com }}</span>
                               <span class="icon" @click="center(city)"><i class="fas fa-crosshairs"></i></span>
                            <span class="icon" @click="removeCity(city)"> <i class="fas fa-times"></i></span>

                        </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import debounce from 'lodash/debounce'
import * as api from '../city/api/api'
import {EVENT_NAME} from "./utils/utils";

export default {
    name: "SearchCity",
    data() {
        return {
            cities: [],
            citiesSelected: [],
            selected: null,
            isFetching: false,
            query: '',
        }
    },
    watch: {
        selected: function () {
            this.isFetching = true;
            api.getCityInformationFromCadastre(this.selected.code)
                .then(r => r.json())
                .then(data => {

                    this.$root.$emit(EVENT_NAME.DISPLAY_CITY, data)
                    this.citiesSelected.push(data.city)
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
            api.getCities(query)
                .then(r => r.json())
                .then(data => {
                    const {cities} = data;
                    this.cities = cities;
                }).catch((error) => {
                throw error
            }).finally(() => {
                this.isFetching = false;
            });
        }, 1000),
        center(city){
            this.$root.$emit(EVENT_NAME.CENTER_CITY, city)
        },
        removeCity(city) {
            this.citiesSelected = this.citiesSelected.filter(c => c.properties.code_insee !== city.properties.code_insee);
            this.$root.$emit(EVENT_NAME.REMOVE_CITY, city)
        }
    }
}
</script>

<style scoped>

</style>
