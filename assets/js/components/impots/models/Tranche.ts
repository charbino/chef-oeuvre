import TrancheInterface from './TrancheInterface';

export default class Tranche {

    constructor(
        private tranche: TrancheInterface
    ) { }

    public get min() {
        return (
            this.tranche.previous && this.tranche.previous.limit
                ? this.tranche.previous.limit - 1
                : -1
        ) + 1;
    }

    public set index(index: number) {
        this.tranche.index = index;
    }

    public set previous(tranche: Tranche | null) {
        this.tranche.previous = tranche;
    }

    public get max() {
        return this.tranche.limit || Infinity;
    }

    public get limit() {
        return this.tranche.limit;
    }

    public get rate() {
        return this.tranche.rate ?? 1;
    }

}
