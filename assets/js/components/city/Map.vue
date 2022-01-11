<template>
    <div>
        <div class="field is-grouped">
            <b-field>
                <b-switch v-model="displayCity" type="is-info">
                    Commune
                </b-switch>
            </b-field>
            <b-field>
                <b-switch v-model="displayDivision" type="is-info">
                    Division
                </b-switch>
            </b-field>
            <b-field>
                <b-switch v-model="displayParcelles" type="is-info">
                    Parcelles
                </b-switch>
            </b-field>
        </div>
        <div class="field is-grouped">
            <b-field label="Opacity">
                <b-slider :custom-formatter="val => val + '%'" v-model="opacity"></b-slider>
            </b-field>
            <b-field label="Fill Opacity">
                <b-slider :custom-formatter="val => val + '%'" v-model="fillOpacity"></b-slider>
            </b-field>
            <div class="field">
                <label class="label">Couleur</label>
                <div class="control">
                    <input class="input" type="color" v-model="colorPlots">
                </div>
            </div>
        </div>

        <l-map
            :center="center"
            :zoom="zoom"
            class="map"
            ref="map">

            <l-tile-layer :url="url"></l-tile-layer>
            <l-geo-json
                v-if="show"
                :geojson="geojsonDepartement"
                :options="options"
                :options-style="styleFunction"
            />

            <l-geo-json
                v-if="displayCity"
                v-for="(geoJSON,index) in geoJSONs"
                :key="index"
                :geojson="geoJSON"
                :options="options"
                :options-style="styleFunction"
            ></l-geo-json>

            <l-geo-json
                v-if="displayDivision"
                v-for="(plots,index) in plotsCities"
                :key="index"
                :geojson="plots"
                :options="optionsPlots"
                :options-style="styleFunctionPlots"
            ></l-geo-json>

            <l-geo-json
                v-if="displayParcelles"
                v-for="(parcelle,index) in parcelles"
                :key="index"
                :geojson="parcelle"
                :options="optionsParcelles"
                :options-style="styleFunctionPlots"
            ></l-geo-json>

        </l-map>
    </div>
</template>

<script>

import {LMap, LTileLayer, LPolygon, LGeoJson} from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';
import {EVENT_NAME} from "./utils/utils";

export default {
    name: "Map",
    components: {
        LMap,
        LTileLayer,
        LPolygon,
        LGeoJson
    },
    data() {
        return {
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            center: [49.1193089, 6.1757156],
            zoom: 5,
            geojsonDepartement: null,
            fillColor: 'green',
            colorPlots: '#53ab6e',
            opacity: 20,
            fillOpacity: 50,
            show: true,
            geoJSONs: [],
            plotsCities: [],
            parcelles: [],
            displayCity: true,
            displayDivision: true,
            displayParcelles: true
        }
    },
    mounted() {
        this.$root.$on(EVENT_NAME.GET_GEOJSON, (geojson) => {
            this.geojsonDepartement = geojson
            const coordinates = geojson[0].geometry.coordinates[0][0];
            this.center = [coordinates[1], coordinates[0]];
            this.zoom = 9;
        })

        this.$root.$on(EVENT_NAME.DISPLAY_CITY, ({city, plots, parcelles}) => {
            this.geoJSONs.push(city)
            this.plotsCities.push(plots);
            this.parcelles.push(parcelles);
            this.centerCity(city);
        })

        this.$root.$on(EVENT_NAME.REMOVE_CITY, (city) => {
            this.removeCity(city)
        })

        this.$root.$on(EVENT_NAME.CENTER_CITY, (city) => {
            this.centerCity(city);
        })
    },
    computed: {
        styleFunction() {
            const fillColor = this.fillColor; // important! need touch fillColor in computed for re-calculate when change fillColor
            return () => {
                return {
                    // weight: 2,
                    // color: "#ECEFF1",
                    // opacity: 1,
                    // fillColor: fillColor,
                    // fillOpacity: 1
                };
            };
        },
        styleFunctionPlots() {
            const fillColor = this.colorPlots;
            const opacity = this.opacity / 100;
            const fillOpacity = this.fillOpacity / 100;

            return () => {
                return {
                    weight: 2,
                    color: "#ECEFF1",
                    opacity: opacity,
                    fillColor: fillColor,
                    fillOpacity: fillOpacity
                };
            };
        },
        options() {
            return {
                onEachFeature: this.onEachFeatureFunction
            };
        },
        optionsPlots() {
            return {
                onEachFeature: this.onEachFeatureFunctionPlots
            };
        },
        optionsParcelles() {
            return {
                onEachFeature: this.onEachFeatureFunctionParcelles
            };
        },
        onEachFeatureFunction() {
            return (feature, layer) => {
                let name = feature.properties.nom_com ? feature.properties.nom_com : feature.properties.nom
                let code = feature.properties.code_insee ? feature.properties.code_insee : feature.properties.code
                let html = `<span class="is-size-6 has-text-weight-semibold">${code} - ${name}</span>`
                layer.bindTooltip(html, {permanent: false, sticky: true, className: 'notification is-link'});
            };
        },
        onEachFeatureFunctionPlots() {
            return (feature, layer) => {
                let section = feature.properties.section;
                let name = feature.properties.nom_com;
                let code = feature.properties.code_insee;
                let html = `<span class="is-size-6 has-text-weight-semibold">${code} - ${name} : ${section}</span>`
                layer.bindTooltip(html, {permanent: false, sticky: true, className: 'notification is-link'});
                // layer.on('onclick', e => {
                //     console.log("clicked", e)
                // });
            };
        },
        onEachFeatureFunctionParcelles() {
            return (feature, layer) => {
                let section = feature.properties.section;
                let name = feature.properties.nom_com;
                let code = feature.properties.code_insee;
                let numero = feature.properties.numero;
                let html = `<span class="is-size-6 has-text-weight-semibold">${code} - ${name} : ${section} - ${numero}</span>`
                layer.bindTooltip(html, {permanent: false, sticky: true, className: 'notification is-link'});
            };
        }
    },
    methods: {
        getCenterGeoJson() {
            if (!this.geojsonDepartement) {
                return this.center;
            }
            const coordinates = this.geojson[0].geometry.coordinates[0][0];

            return [coordinates[1], coordinates[0]];
        },
        centerCity(city) {
            const coordinates = city.geometry.coordinates[0][0][0];
            this.center = [coordinates[1], coordinates[0]];

            setTimeout(el => {
                this.zoom = 13
            }, 1000)
        },
        removeCity(city) {
            this.geoJSONs = this.geoJSONs.filter(c => c.properties.code_insee !== city.properties.code_insee);
            this.plotsCities = this.plotsCities.filter(c => c.features[0].properties.code_insee !== city.properties.code_insee);
            this.parcelles = this.parcelles.filter(c => c.features[0].properties.code_insee !== city.properties.code_insee);
        }
    }

}
</script>

<style>

</style>
