import AbstractForm, {BaseProperties, baseState, BaseState} from '../../components/Form/AbstractForm';
import {connect} from 'unistore/preact';
import {classNames} from '../../helpers';
import DisabledButton from '../../components/Form/DisabledButton';
import PageWrapper from '../../components/Wrapper/PageWrapper';
import {changeUserPassword, checkResetToken} from '../../repository/user';
import {route} from 'preact-router';
import SuccessModal from "../../components/Modal/SuccessModal";
import {modalActions, modalType} from "../../actions/modalActions";


interface Properties extends BaseProperties {
    resetToken?: string,

    showModal(type: modalType): void;
}
interface State extends BaseState {
    password: string|null,
    password_repeat: string|null,
    isSucceeded: boolean,
}


class ResetPassword extends AbstractForm<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            ...baseState,

            password: null,
            password_repeat: null,
            isSucceeded: false,
        };
    }

    async componentDidMount() {
        const response = await checkResetToken(this.props.resetToken);

        if (response.type !== 'success') {
            route('/404');
        }
    }

    protected resetForm() {
        super.resetForm({
            password: null,
            password_repeat: null,
        });
    }

    private async onSubmit(event: Event) {
        event.preventDefault();

        this.setState({isFormInProcess: true});

        const result = await changeUserPassword(
            this.props.resetToken,
            this.state.password,
            this.state.password_repeat
        );

        this.setState({isFormInProcess: false});

        this.processResponse(
            result,
            (): void => {
                this.setState({isSucceeded: true});
                this.props.showModal('success');
            }
        );
    }

    private onSuccessModalClose() {
        route('/');

        this.props.showModal('login');
    }

    render() {
        if (this.state.isSucceeded) {
            // @ts-ignore
            return <SuccessModal title={'Пароль успешно изменён'} content={'Теперь Вы можете авторизоваться с новым паролем'} onClose={() => this.onSuccessModalClose()} />
        }

        return (
            <PageWrapper title={'Восстановление пароля'} type={'form'}>
                <form className="space-y-6" action="#" onSubmit={(event) => this.onSubmit(event)}>
                    {this.renderGlobalError()}

                    <div>
                        <label
                            htmlFor="reset_password_password"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ваш новый пароль</label>

                        <input
                            type="password"
                            name="password"
                            value={this.state.password}
                            onInput={(event: Event) => this.onInputChanged(event)}
                            id="reset_password_password"
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
                            htmlFor="reset_password_password_repeat"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Повторите Ваш новый пароль</label>

                        <input
                            type="password"
                            name="password_repeat"
                            value={this.state.password_repeat}
                            onInput={(event: Event) => this.onInputChanged(event)}
                            id="reset_password_password_repeat"
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
                        ? <DisabledButton text={'Восстановить'} />
                        : (
                            <button
                                type="submit"
                                className="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >Восстановить</button>
                        )
                    }
                </form>
            </PageWrapper>
        );
    }
}

export default connect([], modalActions)(ResetPassword);
