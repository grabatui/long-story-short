export interface UserInterface {
    id: number|null,
    type: 'unauthorized'|'authorized'
}

export interface StoreStateInterface {
    user: UserInterface|null,
    shownModals: string[]
}

interface ResponseResultError {
    path: string,
    code: string,
    message: string
}

export interface ResponseResult {
    message: string,
    code: number,
    errors: Array<ResponseResultError>
}
