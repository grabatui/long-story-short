import {Store} from 'unistore';
import {DefaultResponseResult, StoreStateInterface, UserInterface} from '../types';
import {getUser, logout} from '../repository/user';
import {getCookie, removeCookie, setCookie} from 'typescript-cookie';


type userActionsType = {
    loadUserToken(state: StoreStateInterface): void;
    storeUserToken(state: StoreStateInterface, token: string|null): void;
    loadUser(state: StoreStateInterface): Promise<any>;
    logout(state: StoreStateInterface): void;
};

export const userActions = (store: Store<StoreStateInterface>): userActionsType => ({
    loadUserToken(state: StoreStateInterface): void {
        store.setState({token: getCookie('jwt_token')})
    },
    storeUserToken(state: StoreStateInterface, token: string|null): void {
        if (!token) {
            removeCookie('jwt_token');
        } else {
            setCookie('jwt_token', token);
        }

        store.setState({token: token});
    },
    async loadUser(state: StoreStateInterface): Promise<any> {
        if (!state.token) {
            return;
        }

        await getUser(state.token).then(
            (response: DefaultResponseResult<UserInterface>) => store.setState({user: response.data})
        );
    },
    logout(state: StoreStateInterface): void {
        logout(state.token).then(
            (response: DefaultResponseResult<any>) => store.setState({
                user: {
                    id: null,
                    type: 'unauthorized',
                },
            })
        );
    },
});
