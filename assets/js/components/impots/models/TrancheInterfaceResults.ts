import Tranche from "./Tranche";

export default interface TrancheInterfaceResults {
    tranche: Tranche;
    amountTax : number;
    taxableAmount: number;
}
