import {AuthorizedInterface, DefaultResponseResult, UserInterface} from '../types';


const makeDefaultApiHeaders = (token: string): any => {
    return {
        'Authorization': 'Bearer ' + token,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    };
};


export const register = async (
    csrf: string,
    email: string,
    name: string,
    password: string,
    password_repeat: string
): Promise<DefaultResponseResult<object>> => {
    return await fetch('/api/v1/authorization/register', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({csrf, email, name, password, password_repeat}),
        mode: 'cors'
    })
        .then((response) => response.json());
};

export const login = async (
    csrf: string,
    email: string,
    password: string
): Promise<DefaultResponseResult<AuthorizedInterface>> => {
    return await fetch('/api/v1/authorization/login', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({csrf, username: email, password}),
        mode: 'cors'
    })
        .then((response) => response.json());
}

export const getUser = async (token: string): Promise<DefaultResponseResult<UserInterface>> => {
    return await fetch('/api/v1/user/init', {headers: makeDefaultApiHeaders(token)})
        .then((response) => response.json());
};

export const logout = async (token: string): Promise<DefaultResponseResult<any>> => {
    return await fetch('/api/v1/authorization/logout', {
        method: 'POST',
        headers: makeDefaultApiHeaders(token),
        mode: 'cors'
    })
        .then((response) => response.json());
};
