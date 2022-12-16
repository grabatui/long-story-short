import {Component} from 'preact';
import {connect} from "unistore/preact";
import ModalWrapper from "./ModalWrapper";
import OutsideClickWrapper from "../Wrapper/OutsideClickWrapper";


interface Properties {}
interface State {}


class LoginModal extends Component<Properties, State> {
    render() {
        return (
            // @ts-ignore
            <ModalWrapper type={'login'} title={'Авторизация'}>
                <div className="p-6 space-y-6">
                    <p className="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    </p>
                </div>
                <div
                    className="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button
                        type="button"
                        className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Авторизоваться
                    </button>
                </div>
            </ModalWrapper>
        );
    }
}

export default connect([])(LoginModal);