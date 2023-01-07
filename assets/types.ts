import {modalType} from './actions/modalActions';


export interface UserInterface {
    id: number|null,
    type: 'unauthorized'|'authorized'
}

export interface StoreStateInterface {
    token: string|null,
    user: UserInterface|null,
    shownModal: modalType|null
}

export interface AuthorizedInterface {
    id: number,
    token: string
}

export interface ResponseResultError {
    path: string,
    code: string,
    message: string
}

export interface DefaultResponseResult<DataType> {
    message: string,
    type: 'success'|'output_error'|'error',
    errors: Array<ResponseResultError>,
    data: DataType|null
}
