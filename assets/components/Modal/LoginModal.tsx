import {connect} from 'unistore/preact';
import ModalWrapper from './ModalWrapper';
import {modalActions} from '../../actions/modalActions';
import AbstractModalForm, {BaseProperties, baseState, BaseState} from './AbstractModalForm';
import {classNames} from '../../helpers';
import {login} from "../../repository/user";


interface Properties extends BaseProperties {}
interface State extends BaseState {
    email: string|null,
    password: string|null,
    remember_me: boolean
}


class LoginModal extends AbstractModalForm<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            ...baseState,
            modalType: 'login',

            email: null,
            password: null,
            remember_me: false
        }
    }

    private openRegistrationModal(event: Event) {
        event.preventDefault();

        this.switchModalTo('registration');
    }

    protected resetForm() {
        super.resetForm({
            email: null,
            password: null,
        });
    }

    private async onSubmit(event: Event) {
        event.preventDefault();

        this.setState({isFormInProcess: true});

        const result = await login(
            this.props.csrf,
            this.state.email,
            this.state.password
        );

        this.setState({isFormInProcess: false});

        this.processResponse(
            result,
            (): void => this.switchModalTo('success')
        );
    }

    render() {
        return (
            // @ts-ignore
            <ModalWrapper type={'login'} title={'Авторизация'}>
                <form className="space-y-6" action="#" onSubmit={async (event) => await this.onSubmit(event)}>
                    {this.renderGlobalError()}

                    <div>
                        <label
                            htmlFor="email"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ваш Email</label>

                        <input
                            type="email"
                            name="email"
                            value={this.state.email}
                            onInput={(event: Event) => this.onInputChanged(event)}
                            id="login_email"
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
                            htmlFor="password"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ваш пароль</label>

                        <input
                            type="password"
                            name="password"
                            value={this.state.password}
                            onInput={(event: Event) => this.onInputChanged(event)}
                            id="login_password"
                            placeholder="••••••••"
                            className={classNames([
                                'bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white',
                                this.state.errors && this.state.errors.email ? 'border-red-500' : 'border-gray-300'
                            ])}
                            required
                        />

                        {this.renderFormError('password')}
                    </div>

                    <div className="flex justify-between">
                        <div className="flex items-start">
                            <div className="flex items-center h-5">
                                <input
                                    id="remember"
                                    type="checkbox"
                                    value=""
                                    className="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                />
                            </div>

                            <label
                                htmlFor="remember"
                                className="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Запомнить</label>
                        </div>

                        <a href="#" className="text-sm text-blue-700 hover:underline dark:text-blue-500">Забыли пароль?</a>
                    </div>

                    <button
                        type="submit"
                        className="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >Авторизоваться</button>

                    <div className="text-sm font-medium text-gray-500 dark:text-gray-300">
                        Ещё не зарегистрированы? <a href="#" className="text-blue-700 hover:underline dark:text-blue-500" onClick={(event) => this.openRegistrationModal(event)}>Создать аккаунт</a>
                    </div>
                </form>
            </ModalWrapper>
        );
    }
}

export default connect([], modalActions)(LoginModal);