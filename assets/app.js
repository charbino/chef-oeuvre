/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import Impots from "./js/components/impots/Impots";
import Iss from "./js/components/iss/Iss";

import Vue from "vue"


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
