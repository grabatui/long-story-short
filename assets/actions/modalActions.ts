import {Store} from "unistore";
import {StoreStateInterface} from "../types";


export type modalType = 'success'|'login'|'registration';
type modalActionsType = {
    showModal(state: StoreStateInterface, type: modalType): void;
    closeModal(state: StoreStateInterface, type: modalType): void;
    switchModals(state: StoreStateInterface, oldType: modalType, newType: modalType): void;
};

export const modalActions = (store: Store<StoreStateInterface>): modalActionsType => ({
    showModal(state: StoreStateInterface, type: modalType): void {
        store.setState({
            shownModals: [...state.shownModals, type]
        });
    },
    closeModal(state: StoreStateInterface, type: modalType) {
        store.setState({
            shownModals: state.shownModals.filter(
                (shownType) => shownType !== type
            )
        });
    },
    switchModals(state: StoreStateInterface, oldType: modalType, newType: modalType) {
        if (oldType === newType) {
            return;
        }

        // @ts-ignore
        this.closeModal(oldType);
        // @ts-ignore
        this.showModal(newType);
    }
});
