import createStore from 'unistore';
import devtools from 'unistore/devtools'
import {StoreStateInterface} from './types';


const initialState: StoreStateInterface = {
    token: null,
    user: {
        id: null,
        type: 'unauthorized',
    },
    shownModal: null,
    initData: null
};


export const store = process.env.NODE_ENV !== 'production'
    ? createStore(initialState)
    : devtools(createStore(initialState));
