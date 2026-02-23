import './styles/app.scss';

import './bootstrap.js';

import Impots from "./js/components/impots/Impots";
import Iss from "./js/components/iss/Iss";
import City from './js/components/city/City'
import Basket from './js/components/basket/Basket'
import PlayersComparator from './js/components/basket/PlayersComparator'

import formInit from './js/common/form'

import Vue from "vue"
import Buefy from 'buefy'
Vue.use(Buefy, { defaultIconPack: 'fas' })

formInit();

const appImpots = document.getElementById('app-impots');
if (appImpots) {
    new Vue({
        el: '#app-impots',
        components: {Impots},
        template: '<Impots/>',
    });
}

const appIss = document.getElementById('app-iss');
if (appIss) {
    new Vue({
        el: '#app-iss',
        components: {Iss},
        template: '<Iss/>',
    });
}

const appCity = document.getElementById('app-city');
if (appCity) {
    new Vue({
        el: '#app-city',
        components: {City},
        template: '<City/>'
    });
}

const appBasket = document.getElementById('app-basket');
if (appBasket) {
    new Vue({
        el: '#app-basket',
        components: {Basket},
        template: '<Basket/>'
    });
}

const appPlayersComparator = document.getElementById('app-player-comparator');
if (appPlayersComparator) {
    new Vue({
        el: '#app-player-comparator',
        components: {PlayersComparator},
        template: '<PlayersComparator/>'
    });
}