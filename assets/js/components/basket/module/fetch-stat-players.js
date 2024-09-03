import {onMounted, reactive} from 'vue'
import * as api from "../api/api";
import player from "../player/Player.vue";
import {EVENT_NAME} from "../utils/utils";

const parameters = reactive({
    seasons: [],
});

const players = reactive({
    data: [],
});

const statsPlayer = reactive({
    data: [],
});

const graphicStatPlayer = reactive({
    labels: [],
    datasets: [],
    loaded: false,
});

export default function useFetchStatsPlayers() {

    const getPlayers = () => {
        return players;
    }

    const addPlayer = (player) => {
        return players.data.push(player)
    }

    const getParameters = () => {
        return parameters;
    }

    const setSeasons = (seasons) => {
        parameters.seasons = seasons;
    }
    const getSeasons = () => {
        return parameters.seasons;
    }

    const getStatPlayers = () => {
        return statsPlayer;
    }

    const getGraphicStatPlayer = () => {
        return graphicStatPlayer;
    }

    const updateStats = () => {
        if (players.data.length > 0) {
            graphicStatPlayer.loaded = false;
            api.getStatsPlayers(getPlayers().data, getParameters())
                .then(r => r.json())
                .then(data => data.graphic)
                .then(graphic => {
                    graphicStatPlayer.datasets = graphic.datasets;
                    graphicStatPlayer.labels = graphic.labels;
                    graphicStatPlayer.loaded = true;
                }).catch((error) => {
                throw error
            }).finally(() => {
                // this.isFetching = false;
            });
        }
    }

    return {
        getPlayers,
        addPlayer,
        setSeasons,
        getSeasons,
        getParameters,
        updateStats,
        getStatPlayers,
        getGraphicStatPlayer
    };
}
