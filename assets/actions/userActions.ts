import {Store} from 'unistore';
import {AuthorizationDataInterface, DefaultResponseResult, StoreStateInterface, UserInterface} from '../types';
import {getUser, logout} from '../repository/user';
import {getCookie} from 'typescript-cookie';
import {setTokenToCookie} from '../helpers';


type userActionsType = {
    loadUserToken(state: StoreStateInterface): void;
    storeUserToken(state: StoreStateInterface, token: AuthorizationDataInterface|null): void;
    loadUser(state: StoreStateInterface): Promise<any>;
    logout(state: StoreStateInterface): void;
};

export const userActions = (store: Store<StoreStateInterface>): userActionsType => ({
    loadUserToken(state: StoreStateInterface): void {
        let tokenData: any = getCookie('jwt_token');

        if (tokenData) {
            try {
                tokenData = JSON.parse(tokenData);
            } catch (error) {
                tokenData = null;
            }
        }

        if (tokenData) {
            store.setState({token: tokenData})
        }
    },
    storeUserToken(state: StoreStateInterface, token: AuthorizationDataInterface|null): void {
        setTokenToCookie(token);

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
