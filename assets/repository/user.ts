import {AuthorizationDataInterface, DefaultResponseResult, UserInterface} from '../types';
import {makeDefaultApiHeaders, refreshTokenAndRedoAction} from './helpers';


export const register = async (
    email: string,
    name: string,
    password: string,
    password_repeat: string
): Promise<DefaultResponseResult<object>> => {
    return await fetch('/api/v1/authorization/register', {
        method: 'POST',
        headers: makeDefaultApiHeaders(),
        body: JSON.stringify({email, name, password, password_repeat}),
        mode: 'cors'
    })
        .then((response) => response.json());
};

export const login = async (
    email: string,
    password: string
): Promise<DefaultResponseResult<AuthorizationDataInterface>> => {
    return await fetch('/api/v1/authorization/login', {
        method: 'POST',
        headers: makeDefaultApiHeaders(),
        body: JSON.stringify({username: email, password}),
        mode: 'cors'
    })
        .then((response) => response.json());
}

export const refreshToken = async (
    refreshToken: string
): Promise<DefaultResponseResult<AuthorizationDataInterface>> => {
    return await fetch('/api/v1/authorization/refresh_token', {
        method: 'POST',
        headers: makeDefaultApiHeaders(),
        body: JSON.stringify({refresh_token: refreshToken}),
        mode: 'cors'
    })
        .then((response) => response.json());
}

export const sendRestorePassword = async (
    email: string
): Promise<DefaultResponseResult<object>> => {
    return await fetch('/api/v1/authorization/restore_password', {
        method: 'POST',
        headers: makeDefaultApiHeaders(),
        body: JSON.stringify({email}),
        mode: 'cors'
    })
        .then((response) => response.json());
};

export const getUser = async (token?: AuthorizationDataInterface): Promise<DefaultResponseResult<UserInterface>> => {
    return await fetch('/api/v1/user/init', {headers: makeDefaultApiHeaders(token?.token)})
        .then((response) => response.json())
        .then(
            (response: DefaultResponseResult<UserInterface>) => refreshTokenAndRedoAction(
                token,
                response,
                (token: AuthorizationDataInterface) => getUser(token)
            )
        );
};

export const logout = async (token: AuthorizationDataInterface): Promise<DefaultResponseResult<object>> => {
    return await fetch('/api/v1/authorization/logout', {
        method: 'POST',
        headers: makeDefaultApiHeaders(token.token),
        mode: 'cors'
    })
        .then((response) => response.json())
        .then(
            (response: DefaultResponseResult<object>) => refreshTokenAndRedoAction(
                token,
                response,
                (token: AuthorizationDataInterface) => logout(token)
            )
        );
};

export const checkResetToken = async (reset_token: string): Promise<DefaultResponseResult<object>> => {
    return await fetch('/api/v1/authorization/check_reset_token', {
        method: 'POST',
        headers: makeDefaultApiHeaders(),
        body: JSON.stringify({reset_token}),
        mode: 'cors'
    })
        .then((response) => response.json());
};

export const changeUserPassword = async (
    reset_token: string,
    password: string,
    password_repeat: string
): Promise<DefaultResponseResult<object>> => {
    return await fetch('/api/v1/authorization/change_password', {
        method: 'POST',
        headers: makeDefaultApiHeaders(),
        body: JSON.stringify({reset_token, password, password_repeat}),
        mode: 'cors'
    })
        .then((response) => response.json());
};
