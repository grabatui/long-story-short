import {Store} from 'unistore';
import {StoreStateInterface} from '../types';


export type modalType = 'success'|'login'|'registration'|'restore_password';
type modalActionsType = {
    showModal(state: StoreStateInterface, type: modalType): void;
    closeModal(state: StoreStateInterface): void;
};

export const modalActions = (store: Store<StoreStateInterface>): modalActionsType => ({
    showModal(state: StoreStateInterface, type: modalType): void {
        store.setState({shownModal: type});
    },
    closeModal(state: StoreStateInterface) {
        store.setState({shownModal: null});
    },
});
