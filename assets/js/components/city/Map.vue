<template>
    <article class="media section-map">
        <l-map
            :center="center"
            :zoom="zoom"
            class="map"
            ref="map"
        >
            <l-tile-layer :url="url"></l-tile-layer>
            <l-geo-json
                v-if="show"
                :geojson="geojson"
                :options="options"
                :options-style="styleFunction"
            />
        </l-map>
    </article>
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
            zoom: 9,
            geojson: null,
            fillColor: 'green',
            show: true
        }
    },
    mounted() {
        this.$root.$on(EVENT_NAME.GET_GEOJSON, (geojson) => {
            this.geojson = geojson
            this.center = this.getCenterGeoJson();
            console.log('Geojson',geojson)
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
                layer.bindTooltip(
                    "<div>code:" +
                    feature.properties.code +
                    "</div><div>nom: " +
                    feature.properties.nom +
                    "</div>",
                    { permanent: false, sticky: true }
                );
            };
        }
    },
    methods: {
        getCenterGeoJson(){
            if(!this.geojson){
                return this.center;
            }

            const coordinates = this.geojson[0].geometry.coordinates[0][0];
            console.log('coordinates',coordinates)

            return [coordinates[1],coordinates[0]];
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
