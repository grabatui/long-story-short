import createStore from 'unistore';
import devtools from 'unistore/devtools'


const initialState: any = {
    user: null,
};


export const store = process.env.NODE_ENV !== 'production'
    ? createStore(initialState)
    : devtools(createStore(initialState));
