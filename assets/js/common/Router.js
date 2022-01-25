import Routing from "../../../public/bundles/fosjsrouting/js/router";

const routes = require('../../../public/js/fos_js_routes.json');

class Router {
    routing;

    constructor() {
        if (!Router.instance) {
            this.routing = Routing;
            this.routing.setRoutingData(routes);

            Router.instance = this;
        }

        return Router.instance;
    }

    /**
     *
     * @param route  string
     * @param params object
     * @returns {*}
     */
    generate(route, params = {}) {
        return this.routing.generate(route, params);
    }
}

export default new Router();
