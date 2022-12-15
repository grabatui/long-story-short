import {Store} from "unistore";

export type userActionsType = {
    loadUserAction(): void;
};

export const userActions = (store: Store<any>): userActionsType => ({
    loadUserAction(): void {
        fetch('/api/v1/user/init')
            .then((result) => result.json())
            .then((result) => store.setState({user: result}));
    }
});
