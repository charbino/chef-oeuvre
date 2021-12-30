export default class FoyerFiscal {

    constructor(
        public inCouple: boolean = false,
        public totalChilds: number = 0,
        public nbChildsCMI: number = 0,
    ) {}

    /**
     * Retourne le nombre de parts du foyer (adultes et enfants)
     *
     * @returns {number} Nombre de parts totale du foyer fiscal
     */
    public getNbShares(): number {
        return this.getNbSharesCouple() + this.getnbSharesEnfants();
    }

    /**
     * Retourne le nombre de part du foyer pour les adultes.
     * S'ils sont en couples (mariés ou pacsé), on compte 2 parts, sinon 1
     *
     * @returns {number} Nombre de parts pour les adultes
     */
    private getNbSharesCouple() {
        return this.inCouple ? 2 : 1;
    }

    /**
     * Retourne le nombre de parts par rapport au nombre d'enfants à charge dans le foyer fiscal.
     *
     * Exemples :
     * 1 enfant : 0,5 part
     * 2 enfants : 1 part
     * 3 enfants : 2 parts (à partir de 3 enfants, chaque enfant apporte 1 part supplémentaire)
     * 4 enfants : 3 parts
     *
     * Les enfants titulaires d'une carte CMI ouvrent le droit à une demi-part de quotient familial supplémentaire
     *
     * @returns  {number}  Nombre de parts pour les enfants
     */
    private getnbSharesEnfants() {
        return (
            (this.totalChilds > 2
                ? this.totalChilds - 1
                : this.totalChilds / 2)
            + (this.nbChildsCMI / 2)     // Ajout des demi-part pour les enfants CMI
        );
    }

}
