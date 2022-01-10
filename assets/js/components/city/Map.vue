<template>
    <l-map
        :center="center"
        :zoom="zoom"
        class="map"
        ref="map"
    >
        <l-tile-layer :url="url"></l-tile-layer>
        <l-geo-json
            v-if="show"
            :geojson="geojsonDepartement"
            :options="options"
            :options-style="styleFunction"
        />

        <l-geo-json
            v-for="(geoJSON,index) in geoJSONs"
            :key="index"
            :geojson="geoJSON"
            :options="options"
            :options-style="styleFunction"
        ></l-geo-json>

    </l-map>
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
            show: true,
            geoJSONs: []
        }
    },
    mounted() {
        this.$root.$on(EVENT_NAME.GET_GEOJSON, (geojson) => {
            this.geojsonDepartement = geojson
            const coordinates = geojson[0].geometry.coordinates[0][0];
            this.center = [coordinates[1], coordinates[0]];
            this.zoom = 9;
        })

        this.$root.$on(EVENT_NAME.DISPLAY_CITY, (city) => {
            const coordinates = city.geometry.coordinates[0][0][0];
            this.center = [coordinates[1], coordinates[0]];
            this.zoom = 13;
            this.geoJSONs.push(city)
        })

        this.$root.$on(EVENT_NAME.REMOVE_CITY, (city) => {
            this.removeCity(city)
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
        options() {
            return {
                onEachFeature: this.onEachFeatureFunction
            };
        },
        onEachFeatureFunction() {
            return (feature, layer) => {
                let name = feature.properties.nom_com ? feature.properties.nom_com : feature.properties.nom
                let code = feature.properties.code_insee ? feature.properties.code_insee : feature.properties.code
                let html = `<span class="is-size-6 has-text-weight-semibold">${code} - ${name}</span>`
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
        removeCity(city) {
            this.geoJSONs = this.geoJSONs.filter(c => c.properties.code_insee !== city.properties.code_insee);
        }
        // zoomUpdated(zoom) {
        //     this.zoom = zoom;
        // },
        // centerUpdated(center) {
        //     this.center = center;
        // },
    }

}
</script>

<style>

</style>
