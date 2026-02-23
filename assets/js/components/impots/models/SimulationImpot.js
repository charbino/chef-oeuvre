export default class SimulationImpots {
    constructor(bareme, foyerFiscal) {
        this.bareme = bareme;
        this.foyerFiscal = foyerFiscal;
    }
    findTaxableIncome(afterTaxRevenuesAttendus) {
        let afterTaxRevenues = 0;
        let taxableIncome = afterTaxRevenuesAttendus;
        let detailsImpots = null;
        let maxIterationsAllowed = 30;
        let nombreIterations = 0;
        const startTime = +new Date();
        while (afterTaxRevenues !== afterTaxRevenuesAttendus &&
            nombreIterations < maxIterationsAllowed) {
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
        };
    }
    calcTaxes(taxableIncome) {
        const nbShares = this.foyerFiscal.getNbShares();
        const familyQuotient = this.getFamilyQuotient(taxableIncome, nbShares);
        const taxByBracket = this.getTaxeByBracket(familyQuotient);
        const taxesTotal = this.getTaxTotal(taxByBracket);
        const marginalTaxBracket = this.bareme.getmarginalTaxBracket(familyQuotient);
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
    getFamilyQuotient(taxableIncome, nbShares) {
        return Math.round(taxableIncome / nbShares);
    }
    getTaxTotal(taxByBracket) {
        const impotTotalParPart = taxByBracket.reduce((total, trancheDetails) => (total + trancheDetails.amountTax), 0);
        const impotTotalDuFoyer = impotTotalParPart * this.foyerFiscal.getNbShares();
        return Math.round(impotTotalDuFoyer);
    }
    getTaxeByBracket(quotientFamilial) {
        return this.bareme.tranches.map(tranche => {
            if (quotientFamilial > tranche.max) {
                const taxableAmount = tranche.max - tranche.min;
                return {
                    taxableAmount,
                    amountTax: taxableAmount * tranche.rate,
                    tranche,
                };
            }
            else if (quotientFamilial >= tranche.min && quotientFamilial <= tranche.max) {
                const taxableAmount = quotientFamilial - tranche.min;
                return {
                    taxableAmount,
                    amountTax: taxableAmount * tranche.rate,
                    tranche,
                };
            }
            else {
                return {
                    taxableAmount: 0,
                    amountTax: 0,
                    tranche,
                };
            }
        });
    }
}
