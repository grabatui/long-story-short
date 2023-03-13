import {makeDefaultApiHeaders} from './helpers';
import {AuthorizationDataInterface, DefaultResponseResult, EntitiesInterface} from '../types';


export const entitySearch = async (
    term: string,
    signal: AbortSignal,
    type: string,
    token?: AuthorizationDataInterface
): Promise<DefaultResponseResult<EntitiesInterface>> => {
    return await fetch(encodeURI(`/api/v1/entity/search?type=${type}&term=${term}`), {
        method: 'GET',
        headers: makeDefaultApiHeaders(token?.token),
        mode: 'cors',
        signal: signal
    })
        .then((response) => response.json());
}
