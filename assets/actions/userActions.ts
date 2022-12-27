import {Store} from 'unistore';
import {DefaultResponseResult, StoreStateInterface, UserInterface} from '../types';
import {getUser} from '../repository/user';
import {getCookie, setCookie} from 'typescript-cookie';


type userActionsType = {
    loadUserToken(state: StoreStateInterface): void;
    storeUserToken(state: StoreStateInterface, token: string): void;
    loadUserAction(state: StoreStateInterface): void;
};

export const userActions = (store: Store<StoreStateInterface>): userActionsType => ({
    loadUserToken(state: StoreStateInterface): void {
        store.setState({token: getCookie('jwt_token')})
    },
    storeUserToken(state: StoreStateInterface, token: string): void {
        setCookie('jwt_token', token);
    },
    loadUserAction(state: StoreStateInterface): void {
        if (!state.token) {
            return;
        }

        getUser(state.token).then(
            (response: DefaultResponseResult<UserInterface>) => store.setState({user: response.data})
        );
    }
});
