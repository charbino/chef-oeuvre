import Bareme from './Bareme';
import FoyerFiscal from './FoyerFiscal';
import TrancheInterfaceResults from './TrancheInterfaceResults';
import TrancheInterface from './TrancheInterface';
import DetailsImpotsInterface from './DetailsImpotsInterface';

export default class SimulationImpots {

    constructor(
        public bareme: Bareme,
        public foyerFiscal: FoyerFiscal,
    ) {}

    public findTaxableIncome(afterTaxRevenuesAttendus: number) {

        let afterTaxRevenues: number = 0;
        let taxableIncome = afterTaxRevenuesAttendus;
        let detailsImpots: DetailsImpotsInterface | null = null;
        let maxIterationsAllowed: number = 30;
        let nombreIterations: number = 0;
        const startTime: number = +new Date();

        while(
            afterTaxRevenues !== afterTaxRevenuesAttendus &&
            nombreIterations < maxIterationsAllowed
            ) {
            detailsImpots = this.calcTaxes(taxableIncome);
            afterTaxRevenues = detailsImpots.afterTaxRevenues;
            taxableIncome += (afterTaxRevenuesAttendus - afterTaxRevenues);
            nombreIterations++;
        }

        const tempsTotalEcoule = +new Date() - startTime;

        return {
            taxableIncome,
            detailsImpots,
            meta: {
                nombreIterations,
                tempsTotalEcoule,
            }
        }

    }

    public calcTaxes(taxableIncome: number): DetailsImpotsInterface {
        const nbShares = this.foyerFiscal.getNbShares();
        const familyQuotient: number = this.getFamilyQuotient(taxableIncome, nbShares);
        const taxByBracket: Array<TrancheInterfaceResults> = this.getTaxeByBracket(familyQuotient);
        const taxesTotal: number = this.getTaxTotal(taxByBracket);
        const marginalTaxBracket: TrancheInterface = this.bareme.getmarginalTaxBracket(familyQuotient);
        const afterTaxRevenues = taxableIncome - taxesTotal;
        const ratioDesRevenus = taxesTotal / taxableIncome;

        return {
            ratioDesRevenus,
            nbShares,
            taxableIncome,
            taxesTotal,
            afterTaxRevenues,
            familyQuotient,
            marginalTaxBracket,
            taxByBracket,
        };

    }

    private getFamilyQuotient(taxableIncome: number, nbShares: number): number {
        return Math.round(taxableIncome / nbShares);
    }

    private getTaxTotal(taxByBracket: Array<TrancheInterfaceResults>): number {
        const impotTotalParPart = taxByBracket.reduce(
            (total: number, trancheDetails: TrancheInterfaceResults) => (total + trancheDetails.amountTax),
            0
        );
        const impotTotalDuFoyer = impotTotalParPart * this.foyerFiscal.getNbShares();
        return Math.round(impotTotalDuFoyer);
    }

    private getTaxeByBracket(quotientFamilial: number): Array<TrancheInterfaceResults> {
        return this.bareme.tranches.map(tranche => {
            if (quotientFamilial > tranche.max) {
                const taxableAmount = tranche.max - tranche.min;
                return {
                    taxableAmount,
                    amountTax: taxableAmount * tranche.rate,
                    tranche,
                }
            } else if (quotientFamilial >= tranche.min && quotientFamilial <= tranche.max) {
                const taxableAmount = quotientFamilial - tranche.min;
                return {
                    taxableAmount,
                    amountTax: taxableAmount * tranche.rate,
                    tranche,
                }
            } else {
                return {
                    taxableAmount: 0,
                    amountTax: 0,
                    tranche,
                }
            }
        });
    }

}
