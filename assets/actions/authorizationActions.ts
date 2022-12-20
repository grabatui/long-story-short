import {Store} from "unistore";
import {StoreStateInterface} from "../types";


type authorizationActionsType = {
    register(
        state: StoreStateInterface,
        email: string,
        name: string,
        password: string,
        password_repeat: string
    ): Promise<any>;
};

export const authorizationActions = (store: Store<StoreStateInterface>): authorizationActionsType => ({
    async register(
        state: StoreStateInterface,
        email: string,
        name: string,
        password: string,
        password_repeat: string
    ): Promise<any> {
        return await fetch('/api/v1/authorization/register', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({email, name, password, password_repeat}),
            mode: 'cors'
        })
            .then((result) => result.json())
            .then((result) => console.log(result));
    }
});
