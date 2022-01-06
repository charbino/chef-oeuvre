<template>
    <div>
        <section class="section">
            <Search></Search>
        </section>

        <Map></Map>
    </div>
</template>


<script>

import Search from "./Search";
import Map from "./Map";

export default {
    name: "City",
    components: {Search, Map},
}

</script>
