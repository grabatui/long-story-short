import {DefaultResponseResult, InitDataInterface, StoreStateInterface} from '../types';
import {Store} from 'unistore';
import {getInit} from '../repository/main';


type mainActionsType = {
    loadInit(state: StoreStateInterface): Promise<any>;
};

export const mainActions = (store: Store<StoreStateInterface>): mainActionsType => ({
    async loadInit(state: StoreStateInterface): Promise<any> {
        await getInit(state.token).then(
            (response: DefaultResponseResult<InitDataInterface>) => store.setState({initData: response.data})
        );
    }
});
