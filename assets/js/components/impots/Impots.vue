<template>

    <div>
        <div class="mb-5">
            <div class="select is-medium">
                <select @input="calc" v-model="bareme">
                    <option v-for="option in optionsBareme" :value="option.value">
                        {{ option.text }}
                    </option>
                </select>
            </div>
        </div>

        <article class="panel is-link">
            <p class="panel-heading">
                1. Je renseigne les caractéristiques de mon foyer fiscal
            </p>
            <div class="panel-block">
                <form>
                    <div class="field is-horizontal">
                        <div class="field-label"></div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <label class="checkbox">
                                        <input type="checkbox" v-model="couple" @input="calc">
                                        Je suis marié.e (ou pacsé.e)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label"></div>
                        <div class="field-body">
                            <div class="field">
                                <label class="label">Enfants à charge</label>
                                <div class="control">
                                    <input class="input" type="number" v-model="nbChilds"
                                           @change="adjustNbChildsCMI">
                                </div>
                                <p class="help">Saissisez le nombre d'enfants à votre charge</p>
                            </div>
                            <div class="field">
                                <label class="label">Mes enfants titulaires de la CMI</label>
                                <div class="control">
                                    <input class="input" type="number" v-model="nbChildsCmi"
                                           @change="adjustNbChildsCMI" :disabled="nbChilds==0" :max="nbChilds"
                                           :min="0">
                                </div>
                                <p class="help">Saisissez le nombre de vos enfants titulaires de la CMI parmi tous vos
                                    enfants à chargee</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </article>

        <article class="panel is-link">
            <p class="panel-heading">
                2. Je renseigne mes revenus
            </p>
            <div class="panel-block">
                <form>
                    <div class="field is-horizontal">
                        <div class="field-label"></div>
                        <div class="field-body">
                            <div class="field">
                                <label class="label">Mes revenus imposables</label>
                                <div class="control has-icons-right">
                                    <input class="input" type="number" v-model="netRevenues" @input="calcTaxes"
                                           ref="netRevenues">
                                    <span class="icon is-small is-right">
                                      <i class="fas fa-euro-sign"></i>
                                    </span>
                                </div>
                                <p class="help">Revenu net Imposable</p>
                            </div>
                            <div class="buttons">
                                <button class="button is-info" disabled>
                                    <span class="icon is-small">
                                      <i :class="classArrow"></i>
                                    </span>
                                </button>
                            </div>

                            <div class="field">
                                <label class="label">Mes revenus après impôt</label>
                                <div class="control has-icons-right">
                                    <input class="input" type="number" v-model="afterTaxRevenues"
                                           @input="chercherTaxableIncome">
                                    <span class="icon is-small is-right">
                                      <i class="fas fa-euro-sign"></i>
                                    </span>
                                </div>
                                <p class="help">Revenue net après impots</p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </article>

        <article class="panel is-link">
            <p class="panel-heading">
                3. Je consulte le résultat de ma simulation
            </p>
            <div class="panel-block">
                <ResultImpots :detailsImpots="detailsImpots"></ResultImpots>
            </div>
        </article>
    </div>
</template>

<script>

import ResultImpots from './ResultImpots';
import SimulationImpots from './models/SimulationImpot';
import FoyerFiscal from './models/FoyerFiscal';
import baremesImpots from './utils/barems-impots';

export default {
    name: "Impots",
    components: {
        ResultImpots
    },
    data() {
        return {
            detailsImpots: null,
            bareme: baremesImpots[2020],
            baremesImpots,
            couple: false,
            nbChilds: 0,
            nbChildsCmi: 0,
            netRevenues: 0,
            afterTaxRevenues: 0,
            normalSens: true
        }
    },
    watch: {},
    methods: {
        /**
         * Lance le calcul à partir des valeurs renseignées par défaut
         * et donne le focus au champs "revenus imposables"
         */
        init() {
            // this.calc();
            console.log(this.$refs.netRevenues)
            this.$refs.netRevenues.focus();
        },
        /**
         * Permet de remettre à 0 les champs de revenus
         */
        resetRevenues() {
            this.netRevenues = 0;
            this.afterTaxRevenues = 0;
            this.detailsImpots = null;
        },
        /**
         * Retourne un objet simulation avec les paramètres donnés (barême et infos du foyer fiscal)
         */
        getSimulation() {
            const foyerFiscal = new FoyerFiscal(
                this.couple,
                this.nbChilds,
                this.nbChildsCmi
            )
            return new SimulationImpots(this.bareme, foyerFiscal);
        },
        /**
         * Ajuste le nombre d'enfants CMI :
         * il ne peut pas y avoir plus d'enfant CMI que d'enfant total
         */
        adjustNbChildsCMI() {
            if (this.nbChildsCmi > this.nbChilds) {
                this.nbChildsCmi = this.nbChilds;
            }
            this.calc();
        },
        /**
         * Cherche le revenu imposable par rapport aux revenus apres impots attendus
         */
        chercherTaxableIncome() {
            this.normalSens = false;
            if (!this.afterTaxRevenues) {
                return this.resetRevenues();
            }
            setTimeout(() => {
                this.afterTaxRevenues = Math.round(this.afterTaxRevenues, 10);
                const resultatSimulationRevenus = this.getSimulation().findTaxableIncome(this.afterTaxRevenues);
                this.netRevenues = resultatSimulationRevenus.taxableIncome;
                this.detailsImpots = resultatSimulationRevenus.detailsImpots;
                console.log({
                    "Nombre d'itérations": resultatSimulationRevenus.meta.nombreIterations,
                    "Temps total écoulé": resultatSimulationRevenus.meta.tempsTotalEcoule,
                });
            });
        },
        /**
         * Lance une simulation d'impôts pour un montant de revenus imposables donné
         */
        calcTaxes() {
            this.normalSens = true;
            if (!this.netRevenues) {
                return this.resetRevenues();
            }
            setTimeout(() => {
                this.detailsImpots = this.getSimulation().calcTaxes(this.netRevenues);
                this.afterTaxRevenues = this.detailsImpots.afterTaxRevenues;
            });
        },
        /**
         * Effectue tous les calculs
         */
        calc() {
            if (this.normalSens) {
                this.calcTaxes();
            } else {
                this.chercherTaxableIncome();
            }
        },

    },
    computed: {
        classArrow() {
            if (this.normalSens) {
                return 'fas fa-arrow-right';
            }
            return 'fas fa-arrow-left';
        },
        optionsBareme() {
            return Object.keys(this.baremesImpots)
                .map(annee => ({
                        value: this.baremesImpots[annee],
                        text: `Barème de l'année ${annee}`
                    })
                );
        }
    },
    mounted() {
        this.init();
    },
}
</script>

<style scoped>

</style>
