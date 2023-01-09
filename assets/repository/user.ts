import {AuthorizedInterface, DefaultResponseResult, UserInterface} from '../types';


const makeDefaultApiHeaders = (token?: string|null): any => {
    const headers: any = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    };

    if (token) {
        headers['Authorization'] = 'Bearer ' + token;
    }

    return headers;
};


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
): Promise<DefaultResponseResult<AuthorizedInterface>> => {
    return await fetch('/api/v1/authorization/login', {
        method: 'POST',
        headers: makeDefaultApiHeaders(),
        body: JSON.stringify({username: email, password}),
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

export const getUser = async (token: string): Promise<DefaultResponseResult<UserInterface>> => {
    return await fetch('/api/v1/user/init', {headers: makeDefaultApiHeaders(token)})
        .then((response) => response.json());
};

export const logout = async (token: string): Promise<DefaultResponseResult<object>> => {
    return await fetch('/api/v1/authorization/logout', {
        method: 'POST',
        headers: makeDefaultApiHeaders(token),
        mode: 'cors'
    })
        .then((response) => response.json());
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
