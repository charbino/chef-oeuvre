import Tranche from './Tranche';

export default interface TrancheInterface {
    index?: number;
    limit?: number;
    previous?: Tranche | null;
    rate?: number;
}
