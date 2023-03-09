import {makeDefaultApiHeaders} from './helpers';
import {AuthorizationDataInterface, DefaultResponseResult, EntitiesInterface} from '../types';


export const entitySearch = async (
    term: string,
    signal: AbortSignal,
    type: string,
    token?: AuthorizationDataInterface
): Promise<DefaultResponseResult<EntitiesInterface>> => {
    return await fetch('/api/v1/entity/search', {
        method: 'POST',
        headers: makeDefaultApiHeaders(token?.token),
        body: JSON.stringify({type, term}),
        mode: 'cors',
        signal: signal
    })
        .then((response) => response.json());
}
