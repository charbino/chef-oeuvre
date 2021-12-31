<template>
    <div>
        <p class="block"> API : <a href="https://wheretheiss.at/w/developer" target="_blank">https://wheretheiss.at/w/developer</a></p>
        <Header
            :localistation="localistation"
            :altitude="data.altitude"
            :speed="data.speed"
            :units="data.units"
            :delais="this.getDelaisInSeconde()"
        ></Header>

        <article class="media">
            <l-map
                :zoom="zoom"
                :center="center"
                class="map"
                ref="map">
                <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
                <l-marker :lat-lng="getMarkerLatLong()" v-if="hasMarker()">
                    <l-icon icon-url="/icon/iss.svg" :icon-size="[40, 40]"></l-icon>
                    <l-popup>
                        <div>Hello, je suis <strong> l'ISS </strong>. Je voyage à <span class="tag">{{ data.speed }} Km/h</span>
                        </div>
                    </l-popup>

                </l-marker>
            </l-map>
        </article>
    </div>
</template>

<script>

import * as Vue2Leaflet from 'vue2-leaflet'
import Header from './Header'

var {LMap, LTileLayer, LMarker, LIcon, LPopup} = Vue2Leaflet;

import * as api from './api/api'

const pa = {
    name: 'Albertville',
    longitude: 6.3925417,
    latitude: 45.6754622,
};


export default {
    name: "Iss",
    components: {
        Header,
        LMap,
        LTileLayer,
        LMarker,
        LIcon,
        LPopup
    },
    data() {
        return {
            delais: 10000, //10s
            localistation: '',
            speed: 0,
            zoom: 2,
            center: this.getPointCenter(),
            url: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            markerCentral: this.getPointCenter(),
            isLoading: false,
            // isFullPage: false
            data: {}
        }
    },
    created() {
        this.init();
    },
    methods: {
        loadMarker() {
            api.loadMarker()
                .then(r => r.json())
                .then(data => {
                    this.data = data;
                })
        },
        getPointCenter() {
            return L.latLng(pa.latitude, pa.longitude);
        },
        getMarkerLatLong() {
            if (this.data) {
                return L.latLng(this.data.latitude, this.data.longitude);
            }
        },
        hasMarker: function () {
            let lat = this.data.latitude;
            let long = this.data.longitude;
            return (typeof lat !== 'undefined' && typeof long !== 'undefined');
        },
        getDelaisInSeconde() {
            return this.delais / 1000;
        },
        async init() {
            this.loadMarker();
            this.isLoading = true;
            setInterval(() => {
                this.loadMarker();
            }, this.delais);
        }
    }


}


</script>

<style scoped lang="scss">
.map {
    position: absolute;
    width: 100%;
    height: 500px;
    overflow: hidden
}
</style>
