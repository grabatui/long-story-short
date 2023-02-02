import {AuthorizationDataInterface} from './types';
import {removeCookie, setCookie} from 'typescript-cookie';

export function classNames(items: object|string[]): string {
    if (Array.isArray(items)) {
        return items
            .filter(
                (value) => typeof value !== null
            )
            .join(' ');
    }

    return Array(
        Object.entries(items)
            .filter(
                ([className, state]) => state
            )
            .keys()
        )
        .join(' ');
}

export function setTokenToCookie(token: AuthorizationDataInterface): void {
    if (!token) {
        removeCookie('jwt_token');
    } else {
        setCookie('jwt_token', JSON.stringify({
            'token': token.token,
            'refresh_token': token.refresh_token,
            'refresh_token_expired_at': token.refresh_token_expired_at,
        }));
    }
}
