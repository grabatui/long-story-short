import {modalType} from './actions/modalActions';


export interface UserInterface {
    id: number|null,
    type: 'unauthorized'|'authorized'
}

export interface SearchTypeInterface {
    type: string,
    title: string,
    placeholder: string,
}

export interface InitDataInterface {
    search_types: SearchTypeInterface[]
}

export interface StoreStateInterface {
    token: AuthorizationDataInterface|null,
    user: UserInterface|null,
    shownModal: modalType|null,
    initData: InitDataInterface|null,
}

export interface AuthorizationDataInterface {
    token: string,
    refresh_token: string,
    refresh_token_expired_at: number
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
