import {Match} from 'preact-router/match';
import {Component} from 'preact';
import {connect} from 'unistore/preact';
import XMarkIcon from './Icon/XMarkIcon';
import Bars3Icon from './Icon/Bars3Icon';
import ProfileIcon from './Icon/ProfileIcon';
import {classNames} from '../helpers';
import OutsideClickWrapper from './Wrapper/OutsideClickWrapper';
import {AuthorizationDataInterface, StoreStateInterface} from '../types';
import Loader from './Loader';
import {modalActions, modalType} from '../actions/modalActions';
import {userActions} from '../actions/userActions';
import {store} from '../store';
import {route} from 'preact-router';


interface Properties extends StoreStateInterface {
    showModal(type: modalType): void;
    logout(): void;
    storeUserToken(token: AuthorizationDataInterface|null): void;
}
interface State {
    isMainMenuOpen: boolean,
    isProfileMenuOpen: boolean
}

type LinkItemType = {
    url: string,
    text: string
};
type MatchItemType = {
    matches: boolean,
    path: string,
    url: string
};


const LINKS: LinkItemType[] = [
    {
        url: '/',
        text: 'Главная',
    },
    {
        url: '/movies',
        text: 'Фильмы',
    },
];


class Header extends Component<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            isMainMenuOpen: false,
            isProfileMenuOpen: false,
        };
    }

    private showLoginModal(event: Event) {
        event.preventDefault();

        this.props.showModal('login');
        this.setState({isProfileMenuOpen: false});
    }

    private showRegistrationModal(event: Event) {
        event.preventDefault();

        this.props.showModal('registration');
        this.setState({isProfileMenuOpen: false});
    }

    private logout(event: Event) {
        event.preventDefault();

        this.props.logout();
        this.props.storeUserToken(null);
        this.setState({isProfileMenuOpen: false});
    }

    private toProfile(event: Event) {
        event.preventDefault();

        route('/profile');
        this.setState({isProfileMenuOpen: false});
    }

    private renderProfileMenu() {
        if (!this.props.user) {
            return <Loader />
        }

        let links;

        if (this.props.user.type == 'unauthorized') {
            links = [
                {
                    onClick: (event: Event) => this.showLoginModal(event),
                    text: 'Авторизоваться',
                },
                {
                    onClick: (event: Event) => this.showRegistrationModal(event),
                    text: 'Зарегистрироваться',
                },
            ];
        } else {
            links = [
                {
                    onClick: (event: Event) => this.toProfile(event),
                    text: 'Ваш профиль',
                    url: '/profile'
                },
                {
                    onClick: (event: Event) => this.logout(event),
                    text: 'Выйти',
                },
            ];
        }

        return (
            <Component>
                {links.map(
                    (link: any) => {
                        const linkComponent = (isMatches: boolean) => (
                            <a
                                href="#"
                                className={classNames([
                                    'block px-4 py-2 text-sm',
                                    isMatches ? 'text-blue-700' : 'text-gray-700'
                                ])}
                                onClick={link.onClick}
                            >{link.text}</a>
                        );

                        return link.url
                            ? <Match path={link.url || null}>{(match: MatchItemType) => linkComponent(match.matches)}</Match>
                            : linkComponent(false)
                    }
                )}
            </Component>
        );
    }

    render() {
        return (
            <nav className="bg-gray-800">
                <div className="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                    <div className="relative flex h-16 items-center justify-between">
                        <div className="absolute inset-y-0 left-0 flex items-center sm:hidden">
                            <button
                                type="button"
                                className="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                aria-controls="mobile-menu"
                                aria-expanded="false"
                                onClick={() => this.setState({isMainMenuOpen: !this.state.isMainMenuOpen})}
                            >
                                <span className="sr-only">Открыть меню</span>

                                {this.state.isMainMenuOpen ? <XMarkIcon /> : <Bars3Icon />}
                            </button>
                        </div>

                        <div className="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                            <a href="/">
                                <div className="flex flex-shrink-0 items-center">
                                    <img
                                        className="block h-8 w-auto lg:hidden"
                                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                        alt="Your Company"
                                    />
                                    <img
                                        className="hidden h-8 w-auto lg:block"
                                        src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                        alt="Your Company"
                                    />
                                </div>
                            </a>

                            <div className="hidden sm:ml-6 sm:block">
                                <div className="flex space-x-4">
                                    {LINKS.map((link: LinkItemType) => (
                                        <Match path={link.url}>{(match: MatchItemType) => (
                                            <a
                                                className={
                                                    match.matches
                                                        ? 'bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium'
                                                        : 'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium'
                                                }
                                                href={link.url}
                                            >{link.text}</a>
                                        )}</Match>
                                    ))}
                                </div>
                            </div>
                        </div>

                        <div className="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                            <div className="relative ml-3">

                                <OutsideClickWrapper onOutsideClick={() => this.setState({isProfileMenuOpen: false})}>
                                    <div>
                                        <button
                                            className="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                            onClick={() => this.setState({isProfileMenuOpen: !this.state.isProfileMenuOpen})}
                                        >
                                            <span className="sr-only">Открыть меню</span>

                                            <ProfileIcon />
                                        </button>
                                    </div>

                                    <div
                                        className={classNames([
                                            'absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none',
                                            this.state.isProfileMenuOpen ? null : 'hidden'
                                        ])}
                                    >
                                        {this.renderProfileMenu()}
                                    </div>
                                </OutsideClickWrapper>
                            </div>
                        </div>
                    </div>
                </div>

                <div className={classNames(['sm:hidden', !this.state.isMainMenuOpen ? 'hidden' : null])} id="mobile-menu">
                    <div className="space-y-1 px-2 pt-2 pb-3">
                        {LINKS.map((link: LinkItemType) => (
                            <Match path={link.url}>{(match: MatchItemType) => (
                                <a
                                    className={
                                        match.matches
                                            ? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium'
                                            : 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium'
                                    }
                                    href={link.url}
                                >{link.text}</a>
                            )}</Match>
                        ))}
                    </div>
                </div>
            </nav>
        );
    }
}

export default connect(['user'], {...userActions(store), ...modalActions(store)})(Header);
