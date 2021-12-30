import TrancheInterface from './TrancheInterface';
import Tranche from './Tranche';

export default class Bareme {

    public tranches: Array<Tranche>;

    constructor(
        TrancheInterfaces: Array<TrancheInterface>
    ) {
        this.tranches = TrancheInterfaces
            .map(TrancheInterface => new Tranche(TrancheInterface));

        this.tranches
            .map((tranche, index) => {
                tranche.index = index;
                tranche.previous = index === 0 ? null : this.tranches[index-1];
            })
    }

    /**
     * Retourne la tranche du barème à laquelle correspond le revenu
     *
     * @param {number} familyQuotient Quotient familial à utiliser pour la recherche de la tranche
     * @returns {TrancheInterface} Tranche du barème correspondant au quotient familial
     */
    public getmarginalTaxBracket(familyQuotient: number): TrancheInterface {
        return this.tranches.find((tranche: Tranche) => (
            familyQuotient >= tranche.min && familyQuotient <= tranche.max
        )) as TrancheInterface;
    }

}
