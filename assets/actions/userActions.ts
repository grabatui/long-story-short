import {Store} from "unistore";
import {StoreStateInterface} from "../types";


type userActionsType = {
    loadUserAction(): void;
};

export const userActions = (store: Store<StoreStateInterface>): userActionsType => ({
    loadUserAction(): void {
        fetch('/api/v1/user/init')
            .then((result) => result.json())
            .then((result) => store.setState({user: result}));
    }
});
