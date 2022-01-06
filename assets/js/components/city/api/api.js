import {ROUTES_CITIES} from "../../../common/route";
import Router from "../../../common/Router";

/**
 *
 * @param searchTerms
 * @returns {*}
 */
export const getResults = (searchTerms) => {
    const url = Router.generate(ROUTES_CITIES.SEARCH_DEPARTEMENTS) + '?' + new URLSearchParams(
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

/**
 *
 * @param codeDepartment
 * @returns {*}
 */
export const getCitiesInformations = (codeDepartment) => {
    const url = Router.generate(ROUTES_CITIES.GET_CITIES_INFORMATIONS_FROM_DEPARTEMENT) + '?' + new URLSearchParams(
        {
            query: codeDepartment
        });
    return fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

};
