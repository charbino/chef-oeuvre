/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import { startStimulusApp } from '@symfony/stimulus-bridge';

import Impots from "./js/components/impots/Impots";
import Iss from "./js/components/iss/Iss";
import City from './js/components/city/City'

import * as mercure from './js/components/mercure'
import formInit from './js/common/form'

import Vue from "vue"
import Buefy from 'buefy'
// Vue.use(Buefy)
Vue.use(Buefy, { defaultIconPack: 'fas' })



formInit();
mercure.init();

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

export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.(j|t)sx?$/
));
