import AbstractModalForm, {BaseProperties, baseState, BaseState} from './AbstractModalForm';
import {connect} from 'unistore/preact';
import {modalActions} from '../../actions/modalActions';
import {store} from '../../store';
import {userActions} from '../../actions/userActions';
import ModalWrapper from './ModalWrapper';
import {classNames} from '../../helpers';
import DisabledButton from '../Form/DisabledButton';
import {sendRestorePassword} from '../../repository/user';


interface Properties extends BaseProperties {}
interface State extends BaseState {
    email: string|null
}


class RestorePasswordModal extends AbstractModalForm<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            ...baseState,
            modalType: 'restore_password',

            email: null,
        };
    }

    protected resetForm() {
        super.resetForm({
            email: null,
        });
    }

    private async onSubmit(event: Event) {
        event.preventDefault();

        this.setState({isFormInProcess: true});

        const result = await sendRestorePassword(this.state.email);

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
                <ModalWrapper type={'success'} title={'Письмо отправлено на Вашу почту'} onClose={(): void => this.setPreviousModal()}>
                    <div className="text-sm font-medium text-gray-500 dark:text-gray-300">
                        На почту, указанную в Вашем профиле, было отправлено письмо с информацией о восстановлении Вашего пароля.
                    </div>
                </ModalWrapper>
            );
        }

        return (
            // @ts-ignore
            <ModalWrapper type={'restore_password'} title={'Восстановление пароля'}>
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
            </ModalWrapper>
        );
    }
}

export default connect([], {...modalActions(store), ...userActions(store)})(RestorePasswordModal);
