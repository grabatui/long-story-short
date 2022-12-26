export interface UserInterface {
    id: number|null,
    type: 'unauthorized'|'authorized'
}

export interface StoreStateInterface {
    csrf: string,

    user: UserInterface|null,
    shownModals: string[]
}

export interface ResponseResultError {
    path: string,
    code: string,
    message: string
}

export interface DefaultResponseResult {
    message: string,
    type: 'success'|'output_error'|'error',
    errors: Array<ResponseResultError>,
    data: object|null
}
