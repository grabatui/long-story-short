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
        return this.state.globalError && <FormError error={this.state.globalError} />;
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

    protected onInputChanged(event: Event) {
        const target = event.target;

        if (!(target instanceof HTMLInputElement)) {
            return;
        }

        let changeData: any = {};
        changeData[target.getAttribute('name')] = target.value;

        this.setState(changeData);
    }

    protected processResponse(
        result: DefaultResponseResult,
        onSuccess: () => void,
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
