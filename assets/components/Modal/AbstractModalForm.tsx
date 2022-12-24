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
    switchModals(oldType: modalType, newType: modalType): void;
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
    protected renderFormError(field: string) {
        return this.state.errors && <FormError error={this.state.errors[field]} />;
    }

    protected renderGlobalError() {
        return this.state.globalError && <FormError error={'Приносим извинения за неудобства! Произошла непредвиденная ошибка и мы уже разбираемся!'} />;
    }

    protected switchModalTo(type: modalType): void {
        this.props.switchModals(this.state.modalType, type);

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
        result: DefaultResponseResult,
        onSuccess: () => void,
        onUndefinedError?: (error: string) => void
    ): void {
        const parentOnUndefinedError = onUndefinedError;

        onUndefinedError = (error: string) => {
            //@ts-ignore
            this.setState({
                globalError: error,
            })

            if (parentOnUndefinedError) {
                parentOnUndefinedError(error);
            }
        };

        super.processResponse(result, onSuccess, onUndefinedError);
    }
}

export default AbstractModalForm;
