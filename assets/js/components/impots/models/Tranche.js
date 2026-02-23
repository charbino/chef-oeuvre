export default class Tranche {
    constructor(tranche) {
        this.tranche = tranche;
    }
    get min() {
        return (this.tranche.previous && this.tranche.previous.limit
            ? this.tranche.previous.limit - 1
            : -1) + 1;
    }
    set index(index) {
        this.tranche.index = index;
    }
    set previous(tranche) {
        this.tranche.previous = tranche;
    }
    get max() {
        return this.tranche.limit || Infinity;
    }
    get limit() {
        return this.tranche.limit;
    }
    get rate() {
        var _a;
        return (_a = this.tranche.rate) !== null && _a !== void 0 ? _a : 1;
    }
}
