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

export interface ResponseResult {
    message: string,
    code: number,
    errors: Array<ResponseResultError>
}
