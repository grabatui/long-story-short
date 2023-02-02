import {AuthorizationDataInterface, DefaultResponseResult} from '../types';
import {store} from '../store';
import {refreshToken} from './user';
import {setTokenToCookie} from '../helpers';

export const makeDefaultApiHeaders = (token?: string|null): any => {
    const headers: any = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    };

    if (token) {
        headers['Authorization'] = 'Bearer ' + token;
    }

    return headers;
};

export const refreshTokenAndRedoAction = async (
    token: AuthorizationDataInterface,
    response: DefaultResponseResult<any>,
    action: any
): Promise<any> => {
    if (response.message !== 'Expired JWT Token') {
        return response;
    }

    return await refreshToken(token.refresh_token)
        .then((response: DefaultResponseResult<AuthorizationDataInterface>) => {
            setTokenToCookie(response.data);

            store.setState({token: response.data})

            return response.data;
        })
        .then((response: AuthorizationDataInterface) => action(response));
};
