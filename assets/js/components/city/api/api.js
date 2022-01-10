import {ROUTES_CADASTRE, ROUTES_CITIES} from "../../../common/route";
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
export const getCitiesFromDepartement = (codeDepartment) => {
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

/**
 *
 * @param searchTerms
 * @returns {Promise<Response>}
 */
export const getCities = (searchTerms) => {
    const url = Router.generate(ROUTES_CITIES.SEARCH_CITIES) + '?' + new URLSearchParams(
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
export const getCityInformationFromCadastre = (codeDepartment) => {
    const url = Router.generate(ROUTES_CADASTRE.GET_CITY_INFORMATION) + '?' + new URLSearchParams(
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
