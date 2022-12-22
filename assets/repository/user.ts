import {ResponseResult} from "../types";


export const register = async (
    csrf: string,
    email: string,
    name: string,
    password: string,
    password_repeat: string
): Promise<ResponseResult> => {
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
