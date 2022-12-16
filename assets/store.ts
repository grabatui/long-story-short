import createStore from 'unistore';
import devtools from 'unistore/devtools'
import {StoreStateInterface} from "./types";


const initialState: StoreStateInterface = {
    user: null,
    shownModals: []
};


export const store = process.env.NODE_ENV !== 'production'
    ? createStore(initialState)
    : devtools(createStore(initialState));
