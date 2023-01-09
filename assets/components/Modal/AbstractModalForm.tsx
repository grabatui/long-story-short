import {modalType} from '../../actions/modalActions';
import AbstractForm, {
    BaseProperties as BaseFormProperties,
    BaseState as BaseFormState,
    baseState as baseFormState
} from '../Form/AbstractForm';
import FormError from '../Form/FormError';
import {DefaultResponseResult} from '../../types';


export interface BaseProperties extends BaseFormProperties {
    showModal(type: modalType): void;
    closeModal(): void;
}
export interface BaseState extends BaseFormState {
    modalType: modalType|null,
    previousModalType: modalType|null
}

export const baseState: BaseState = {
    ...baseFormState,

    modalType: null,
    previousModalType: null
};


abstract class AbstractModalForm<ChildProperties, ChildState> extends AbstractForm<ChildProperties & BaseProperties, ChildState & BaseState>{
    protected switchModalTo(type: modalType): void {
        this.props.showModal(type);

        //@ts-ignore
        this.setState({
            modalType: type,
            previousModalType: this.state.modalType,
        });
    }

    protected setPreviousModal(): void {
        //@ts-ignore
        this.setState({
            modalType: this.state.previousModalType,
            previousModalType: null,
        });
    }

    protected processResponse(
        result: DefaultResponseResult<object>,
        onSuccess?: () => any,
        onUndefinedError?: (error: string, errorType: string) => void
    ): void {
        const parentOnUndefinedError = onUndefinedError;

        onUndefinedError = (error: string, errorType: string) => {
            //@ts-ignore
            this.setState({
                globalError: errorType === 'output_error'
                    ? error
                    : 'Приносим извинения за неудобства! Произошла непредвиденная ошибка и мы уже разбираемся!',
            })

            if (parentOnUndefinedError) {
                parentOnUndefinedError(error, errorType);
            }
        };

        super.processResponse(result, onSuccess, onUndefinedError);
    }
}

export default AbstractModalForm;
