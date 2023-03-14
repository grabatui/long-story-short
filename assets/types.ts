import {modalType} from './actions/modalActions';


export interface UserInterface {
    id: number|null,
    type: 'unauthorized'|'authorized',
    email: string|null,
    allows: 'create_entity_request'|'another'[]
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

export interface EntityInterface {
    id: number,
    title: string,
    original_title: string|null,
    poster: string,
    url: string,
    premiered_year: string
    countries: string[],
    genres: string[]
}

export interface EntitiesInterface {
    items: EntityInterface[]
}
