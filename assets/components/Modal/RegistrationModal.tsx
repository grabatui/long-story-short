import {connect} from 'unistore/preact';
import ModalWrapper from './ModalWrapper';
import {modalActions} from '../../actions/modalActions';
import {register} from '../../repository/user';
import {classNames} from '../../helpers';
import DisabledButton from '../Form/DisabledButton';
import AbstractModalForm, {BaseProperties, baseState, BaseState} from './AbstractModalForm';


interface Properties extends BaseProperties {}
interface State extends BaseState {
    email: string|null,
    name: string|null,
    password: string|null,
    password_repeat: string|null
}


class RegistrationModal extends AbstractModalForm<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            ...baseState,
            modalType: 'registration',

            email: null,
            name: null,
            password: null,
            password_repeat: null,
        };
    }

    private openLoginModal(event: Event) {
        event.preventDefault();

        this.switchModalTo('login');
    }

    protected resetForm() {
        super.resetForm({
            email: null,
            name: null,
            password: null,
            password_repeat: null,
        });
    }

    private async onSubmit(event: Event) {
        event.preventDefault();

        this.setState({isFormInProcess: true});

        const result = await register(
            this.state.email,
            this.state.name,
            this.state.password,
            this.state.password_repeat
        );

        this.setState({isFormInProcess: false});

        this.processResponse(
            result,
            (): void => this.switchModalTo('success')
        );
    }

    render() {
        if (this.state.modalType === 'success') {
            return (
                // @ts-ignore
                <ModalWrapper type={'success'} title={'Вы успешно зарегистрированы!'} onClose={(): void => this.setPreviousModal()}>
                    <div className="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Теперь Вы можете <a href="#" className="text-blue-700 hover:underline dark:text-blue-500" onClick={(event) => this.openLoginModal(event)}>авторизоваться</a>.
                    </div>
                </ModalWrapper>
            );
        }

        return (
            // @ts-ignore
            <ModalWrapper type={'registration'} title={'Регистрация'}>
                <form className="space-y-6" action="#" onSubmit={async (event) => await this.onSubmit(event)}>
                    {this.renderGlobalError()}

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

                        {this.renderFormError('email')}
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

                        {this.renderFormError('name')}
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

                        {this.renderFormError('password')}
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

                        {this.renderFormError('password_repeat')}
                    </div>

                    {this.state.isFormInProcess
                        ? <DisabledButton text={'Зарегистрироваться'} />
                        : (
                            <button
                                type="submit"
                                className="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >Зарегистрироваться</button>
                        )
                    }

                    <div className="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Уже есть аккаунт? <a href="#" className="text-blue-700 hover:underline dark:text-blue-500" onClick={(event) => this.openLoginModal(event)}>Авторизоваться</a>
                    </div>
                </form>
            </ModalWrapper>
        );
    }
}

export default connect([], modalActions)(RegistrationModal);
