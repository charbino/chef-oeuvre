<template>
    <div>
        <div class="content">
            <ul>
                <li><a href="https://api.gouv.fr/documentation/api_carto_cadastre">API Découpage Administratif</a></li>
                <li><a href="https://api.gouv.fr/documentation/api_carto_cadastre">API Cadastre</a></li>
            </ul>
        </div>
        <div class="columns">
            <article class="media section-map column is-three-quarters">
                <Map></Map>
            </article>
            <div class="column">
                <PanelControl></PanelControl>
            </div>
        </div>
    </div>
</template>


<script>

import Map from "./Map";
import PanelControl from "./PanelControl";

export default {
    name: "City",
    components: {Map, PanelControl},
}

</script>
