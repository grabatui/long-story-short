import {Component} from 'preact';
import {connect} from 'unistore/preact';
import ModalWrapper from './ModalWrapper';
import {StoreStateInterface} from '../../types';
import {modalActions, modalType} from "../../actions/modalActions";


interface Properties extends StoreStateInterface {
    switchModals(oldType: modalType, newType: modalType): void;
}
interface State {}


class LoginModal extends Component<Properties, State> {
    private openRegistrationModal(event: Event) {
        event.preventDefault();

        this.props.switchModals('login', 'registration');
    }

    render() {
        return (
            // @ts-ignore
            <ModalWrapper type={'login'} title={'Авторизация'}>
                <form className="space-y-6" action="#">
                    <div>
                        <label
                            htmlFor="email"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ваш Email</label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="your@email.com"
                            required
                        />
                    </div>
                    <div>
                        <label
                            htmlFor="password"
                            className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ваш пароль</label>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required
                        />
                    </div>

                    <div className="flex justify-between">
                        <div className="flex items-start">
                            <div className="flex items-center h-5">
                                <input
                                    id="remember"
                                    type="checkbox"
                                    value=""
                                    className="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                                    required
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