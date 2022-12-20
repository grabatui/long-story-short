import {Component} from 'preact';
import {connect} from 'unistore/preact';
import ModalWrapper from './ModalWrapper';
import {StoreStateInterface} from '../../types';
import {modalActions, modalType} from '../../actions/modalActions';
import {authorizationActions} from '../../actions/authorizationActions';
import {store} from '../../store';


interface Properties extends StoreStateInterface {
    switchModals(oldType: modalType, newType: modalType): void;
    register(email: string, name: string, password: string, password_repeat: string): Promise<any>;
}
interface State {
    email: string|null,
    name: string|null,
    password: string|null,
    password_repeat: string|null,
}


class RegistrationModal extends Component<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            email: null,
            name: null,
            password: null,
            password_repeat: null,
        };
    }

    private openLoginModal(event: Event) {
        event.preventDefault();

        this.props.switchModals('registration', 'login');
    }

    private onInputChanged(event: Event) {
        const target = event.target;

        if (!(target instanceof HTMLInputElement)) {
            return;
        }

        let changeData: any = {};
        changeData[target.getAttribute('name')] = target.value;

        this.setState(changeData);
    }

    private onSubmit(event: Event) {
        event.preventDefault();

        this.props.register(this.state.email, this.state.name, this.state.password, this.state.password_repeat)
            .then();
    }

    render() {
        return (
            // @ts-ignore
            <ModalWrapper type={'registration'} title={'Регистрация'}>
                <form className="space-y-6" action="#" onSubmit={(event) => this.onSubmit(event)}>
                    <div>
                        <label
                            htmlFor="registration_email"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ваш Email</label>

                        <input
                            type="email"
                            name="email"
                            value={this.state.email}
                            onInput={(event: Event) => this.onInputChanged(event)}
                            id="registration_email"
                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="john@doe.com"
                            required
                        />
                    </div>

                    <div>
                        <label
                            htmlFor="registration_name"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ваше имя</label>

                        <input
                            type="text"
                            name="name"
                            value={this.state.name}
                            onInput={(event: Event) => this.onInputChanged(event)}
                            id="registration_name"
                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="John Doe"
                            required
                        />
                    </div>

                    <div>
                        <label
                            htmlFor="registration_password"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ваш пароль</label>

                        <input
                            type="password"
                            name="password"
                            value={this.state.password}
                            onInput={(event: Event) => this.onInputChanged(event)}
                            id="registration_password"
                            placeholder="••••••••"
                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required
                        />
                    </div>

                    <div>
                        <label
                            htmlFor="registration_password_repeat"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Повторите Ваш пароль</label>

                        <input
                            type="password"
                            name="password_repeat"
                            value={this.state.password_repeat}
                            onInput={(event: Event) => this.onInputChanged(event)}
                            id="registration_password_repeat"
                            placeholder="••••••••"
                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required
                        />
                    </div>

                    <button
                        type="submit"
                        className="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >Зарегистрироваться</button>

                    <div className="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Уже есть аккаунт? <a href="#" className="text-blue-700 hover:underline dark:text-blue-500" onClick={(event) => this.openLoginModal(event)}>Авторизоваться</a>
                    </div>
                </form>
            </ModalWrapper>
        );
    }
}

export default connect([], {...modalActions(store), ...authorizationActions(store)})(RegistrationModal);