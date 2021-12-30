import TrancheInterfaceResults from './TrancheInterfaceResults';
import TrancheInterface from './TrancheInterface';

export default interface DetailsImpotsInterface {
    ratioDesRevenus: number;
    nbShares: number;
    taxableIncome: number;
    taxesTotal: number;
    afterTaxRevenues: number;
    familyQuotient: number;
    marginalTaxBracket: TrancheInterface;
    taxByBracket: Array<TrancheInterfaceResults>;
};
