import {connect} from 'unistore/preact';
import {modalActions, modalType} from '../../actions/modalActions';
import ModalWrapper from './ModalWrapper';
import {Component} from 'preact';


interface Properties {
    title: string,
    content: string,
    onClose(): void;
}
interface State {
    modalType: modalType,
}


class SuccessModal extends Component<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            modalType: 'success',
        };
    }

    render() {
        return (
            // @ts-ignore
            <ModalWrapper type={'success'} title={this.props.title} onClose={() => this.props.onClose()}>
                <div className="text-sm font-medium text-gray-500 dark:text-gray-300">
                    {this.props.content}
                </div>
            </ModalWrapper>
        );
    }
}

export default connect([], modalActions)(SuccessModal);
