<template>
    <div>
        <div v-if="!detailsImpots" class="notification is-warning">
            Saisissez un montant dans la case "Revenus imposables" ou "Revenus après impôt" pour lancer la simulation
        </div>
        <div v-else>
            <p>
                Le montant de <strong>votre impôt est de <span class="tag is-info">{{ detailsImpots.taxesTotal | currency }}</span></strong>
                ce qui représente <span class="tag is-light">{{detailsImpots.ratioDesRevenus | percent}}</span>de vos revenus imposables.
            </p>
            <p>Le montant de vos revenus imposables s'élèvant à <span class="tag is-light">{{detailsImpots.taxableIncome | currency}}</span> et <strong>votre foyer fiscal</strong> comprenant <span class="tag is-info">{{detailsImpots.nbShares}} {{detailsImpots.nbShares >= 2 ? 'parts' : 'part'}}</span>, votre quotient familial est donc de <span class="tag is-light">{{detailsImpots.familyQuotient | currency}}</span></p>
            <p>En soumettant ce quotient familial de <span class="tag is-light">{{detailsImpots.familyQuotient | currency}}</span> au barême, on constate
                <span v-if="detailsImpots.marginalTaxBracket.max !== Infinity">qu'il est compris entre <span class="tag is-light">{{detailsImpots.marginalTaxBracket.min | currency}}</span> et <span class="tag is-light">{{detailsImpots.marginalTaxBracket.max | currency}}</span></span>
                <span v-if="detailsImpots.marginalTaxBracket.max === Infinity">qu'il est supérieur ou égal à <span class="tag is-light">{{detailsImpots.marginalTaxBracket.min | currency}}</span></span>
                ce qui donne un <strong>taux marginal d'imposition</strong> de <span class="tag is-info">{{detailsImpots.marginalTaxBracket.rate | percent}}</span>.
            </p>
            <div class="bareme">
                <div class="legende">
                    <span class="montant">Montant<br>des revenus</span>
                    <span class="rate">% d'imposition</span>
                </div>
                <ol>
                    <li v-for="(trancheResult, index) in taxByBracket" :key="index">
                        <span class="max" v-if="trancheResult.tranche.max !== Infinity">{{trancheResult.tranche.max}}</span>
                        <span class="rate"><span v-if="trancheResult.tranche.rate === detailsImpots.marginalTaxBracket.rate" class="triangle-rate"></span>{{Math.round(trancheResult.tranche.rate * 100)}}</span>
                        <span class="impots">{{trancheResult.taxableAmount | currency}} x {{trancheResult.tranche.rate | percent}} = {{Math.round(trancheResult.amountTax) | currency}}</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>

<script>

const formatCurrency = new Intl.NumberFormat('fr-FR', {style: 'currency', currency: 'EUR'});
const formatPercent = new Intl.NumberFormat('fr-FR', {style: 'percent'});


export default {
    name: "ResultImpots",
    props: {
        detailsImpots: {
            required: true
        }
    },
    filters: {
        currency: function (montant) {
            return formatCurrency.format(montant);
        },
        percent: function (rate) {
            return formatPercent.format(rate);
        }
    },
    computed: {
        taxByBracket() {
            return this.detailsImpots ? this.detailsImpots.taxByBracket.slice().reverse() : [];
        }
    },
}
</script>

<style scoped>
.bareme {
    position: relative;
    font-family: "Avenir", Helvetica, Arial, sans-serif;
    overflow: hidden;
    border-radius: 5px;
}

.legende span {
    position: absolute;
    top: 10px;
    font-size: 14px;
    color: white;
    z-index: 9;
    text-transform: uppercase;
    display: block;
    font-weight: 500;
}

.legende .montant {
    left: 10px;
}

.legende .rate {
    right: 10px;
}

.bareme ol {
    padding: 0;
    margin: 0;
}

.bareme li {
    list-style-type: none;
    padding: 0;
    margin: 0;
    position: relative;
}

.bareme li::after {
    content: '';
    z-index: 9;
    background: white;
    height: 2px;
    width: 100%;
    margin-left: 115px;
    position: absolute;
    display: block;
    bottom: -1px;
}

.bareme li:last-child::after {
    display: none;
}

.bareme li span.impots {
    position: absolute;
    bottom: 20px;
    left: 10px;
    height: auto;
    display: block;
    color: white;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 5px;
    padding: 2px 5px;
    font-size: 14px;
}

.bareme li span.max {
    position: absolute;
    top: -17px;
    left: 10px;
    height: auto;
    display: block;
    color: white;
    background: none;
    font-size: 22px;
}

.bareme li span.max::after {
    content: '€';
}

.bareme li span.rate .triangle-rate{
    position: absolute;
    left: -35px;
    top: 16px;
    display : inline-block;
    height : 0;
    width : 0;
    background: transparent;
    border-top : 16px solid transparent;
    border-bottom : 16px solid transparent;
    border-left : 32px solid white;
    line-height: 0;
    overflow: none;
}

.bareme li span.rate {
    position: relative;
    height: auto;
    display: block;
    color: white;
    font-size: 46px;
    background: none;
    position: absolute;
    bottom: 0px;
    right: 10px;
    font-weight: 700;
}

.bareme li span.rate::after {
    content: '%';
}

.bareme ol :nth-child(1) {
    background: #202c4f;
    height: 115px;
}
.bareme ol :nth-child(2) {
    background: #5b366a;
    height: 190px;
}
.bareme ol :nth-child(3) {
    background: #c25086;
    height: 129px;
}
.bareme ol :nth-child(4) {
    background: #d65faa;
    height: 80px;
}
.bareme ol :nth-child(5) {
    background: #e1aed8;
    height: 70px;
}
</style>
