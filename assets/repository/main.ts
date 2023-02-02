import {makeDefaultApiHeaders} from './helpers';
import {AuthorizationDataInterface, DefaultResponseResult, InitDataInterface} from '../types';


export const getInit = async (token?: AuthorizationDataInterface): Promise<DefaultResponseResult<InitDataInterface>> => {
    return await fetch('/api/v1/init', {headers: makeDefaultApiHeaders(token?.token)})
        .then((response) => response.json());
}
