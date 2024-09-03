import {ROUTES_BASKET} from "../../../common/route";
import Router from "../../../common/Router";

export const searchPlayer = (searchTerms) => {
    const url = Router.generate(ROUTES_BASKET.SEARCH_PLAYERS) + '?' + new URLSearchParams(
        {
            query: searchTerms
        });
    return fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

};

export const addPlayer = (player) => {
    return fetch(Router.generate(ROUTES_BASKET.ADD_PLAYER), {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(player)
    });

};

export const getPlayers = () => {
    return fetch(Router.generate(ROUTES_BASKET.GET_PLAYERS), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

};

export const getStatPlayer = (player, filters) => {
    return fetch(Router.generate(ROUTES_BASKET.GET_STAT_PLAYER, {id: player.externalId, ...filters}), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
};

export const getStatsPlayers = (players, filters) => {
    let ids = players.map((player) => player.externalId);
    console.log(ids);
    return fetch(Router.generate(ROUTES_BASKET.COMPARE_PLAYERS, {ids: players.map((player) => player.externalId) , ...filters}), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
};

