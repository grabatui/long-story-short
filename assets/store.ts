import createStore from 'unistore';
import devtools from 'unistore/devtools'
import {StoreStateInterface} from './types';


const initialState: StoreStateInterface = {
    // @ts-ignore
    csrf: window.__CONFIG__.csrf,

    token: null,
    user: {
        id: null,
        type: 'unauthorized',
    },
    shownModals: []
};


export const store = process.env.NODE_ENV !== 'production'
    ? createStore(initialState)
    : devtools(createStore(initialState));
