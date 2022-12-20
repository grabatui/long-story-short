export interface UserInterface {
    id: number|null,
    type: 'unauthorized'|'authorized'
}

export interface StoreStateInterface {
    user: UserInterface|null,
    shownModals: string[]
}
