import {Component} from 'preact';
import {connect} from 'unistore/preact';
import ModalWrapper from './ModalWrapper';
import {StoreStateInterface} from '../../types';
import {modalActions, modalType} from '../../actions/modalActions';
import {register} from '../../repository/user';
import FormError from '../Form/FormError';
import {classNames} from '../../helpers';


interface Properties extends StoreStateInterface {
    switchModals(oldType: modalType, newType: modalType): void;
}
interface State {
    email: string|null,
    name: string|null,
    password: string|null,
    password_repeat: string|null,

    errors: any
}


class RegistrationModal extends Component<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            email: null,
            name: null,
            password: null,
            password_repeat: null,

            errors: null,
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

    private async onSubmit(event: Event) {
        event.preventDefault();

        const result = await register(
            this.props.csrf,
            this.state.email,
            this.state.name,
            this.state.password,
            this.state.password_repeat
        );

        if (result.errors) {
            this.setState({
                errors: result.errors.reduce(
                    (object, error) => ({...object, [error.path]: error.message}),
                    {}
                ),
            });
        }
    }

    render() {
        return (
            // @ts-ignore
            <ModalWrapper type={'registration'} title={'Регистрация'}>
                <form className="space-y-6" action="#" onSubmit={async (event) => await this.onSubmit(event)}>
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
                            className={classNames([
                                'bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white',
                                this.state.errors && this.state.errors.email ? 'border-red-500' : 'border-gray-300'
                            ])}
                            placeholder="john@doe.com"
                            required
                        />

                        {this.state.errors && <FormError error={this.state.errors.email} />}
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
                            className={classNames([
                                'bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white',
                                this.state.errors && this.state.errors.name ? 'border-red-500' : 'border-gray-300'
                            ])}
                            placeholder="John Doe"
                            required
                        />

                        {this.state.errors && <FormError error={this.state.errors.name} />}
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
                            className={classNames([
                                'bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white',
                                this.state.errors && this.state.errors.password ? 'border-red-500' : 'border-gray-300'
                            ])}
                            required
                        />

                        {this.state.errors && <FormError error={this.state.errors.password} />}
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
                            className={classNames([
                                'bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white',
                                this.state.errors && this.state.errors.password_repeat ? 'border-red-500' : 'border-gray-300'
                            ])}
                            required
                        />

                        {this.state.errors && <FormError error={this.state.errors.password_repeat} />}
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

export default connect(['csrf'], modalActions)(RegistrationModal);