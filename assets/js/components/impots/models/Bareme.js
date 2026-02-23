import Tranche from './Tranche';
export default class Bareme {
    constructor(TrancheInterfaces) {
        this.tranches = TrancheInterfaces
            .map(TrancheInterface => new Tranche(TrancheInterface));
        this.tranches
            .map((tranche, index) => {
            tranche.index = index;
            tranche.previous = index === 0 ? null : this.tranches[index - 1];
        });
    }
    /**
     * Retourne la tranche du barème à laquelle correspond le revenu
     *
     * @param {number} familyQuotient Quotient familial à utiliser pour la recherche de la tranche
     * @returns {TrancheInterface} Tranche du barème correspondant au quotient familial
     */
    getmarginalTaxBracket(familyQuotient) {
        return this.tranches.find((tranche) => (familyQuotient >= tranche.min && familyQuotient <= tranche.max));
    }
}
