export interface UserInterface {
    id: number|null,
    type: 'unauthorized'|'authorized'
}

export interface StoreStateInterface {
    csrf: string,

    token: string|null,
    user: UserInterface|null,
    shownModals: string[]
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
