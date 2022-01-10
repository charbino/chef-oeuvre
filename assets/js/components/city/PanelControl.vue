<template>
    <div>
        <h3 class="title is-3">Panel Control</h3>
        <SearchDepartement></SearchDepartement>
        <SearchCity></SearchCity>
    </div>
</template>

<script>

import SearchDepartement from "./SearchDepartement";
import SearchCity from "./SearchCity";

export default {
    name: "PanelControl",
    components: {
        SearchDepartement,
        SearchCity
    }
}
</script>

<style scoped>

</style>
