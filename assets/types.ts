export interface UserInterface {
    id: number|null,
    type: 'unauthorized'|'authorized'|'admin'
}

export interface StoreStateInterface {
    user: UserInterface|null,
    shownModals: string[]
}
