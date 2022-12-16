import {Store} from "unistore";
import {StoreStateInterface} from "./types";


export type userActionsType = {
    loadUserAction(): void;
};

export type modalType = 'login'|'registration';
export type modalActionsType = {
    showModal(state: StoreStateInterface, type: modalType): void;
    closeModal(state: StoreStateInterface, type: modalType): void;
};


export const userActions = (store: Store<StoreStateInterface>): userActionsType => ({
    loadUserAction(): void {
        fetch('/api/v1/user/init')
            .then((result) => result.json())
            .then((result) => store.setState({user: result}));
    }
});

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
        })
    }
});
