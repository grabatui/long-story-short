import {DefaultResponseResult} from "../types";


export const register = async (
    csrf: string,
    email: string,
    name: string,
    password: string,
    password_repeat: string
): Promise<DefaultResponseResult> => {
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
): Promise<any> => {
    return await fetch('/api/v1/authorization/login', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            csrf,
            username: email,
            password,
        }),
        mode: 'cors'
    })
        .then((response) => response.json());
}
