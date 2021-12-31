import {ROUTES_ISS} from "../../../common/route";


import Router from "../../../common/Router";

export function loadMarker() {
    return fetch(Router.generate(ROUTES_ISS.POSITION), {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });
}


