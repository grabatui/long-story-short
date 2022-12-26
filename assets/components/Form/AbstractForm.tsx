import {DefaultResponseResult, StoreStateInterface} from '../../types';
import {Component} from 'preact';


export interface BaseProperties extends StoreStateInterface {}
export interface BaseState {
    globalError: string|null,
    errors: any,
    isFormInProcess: boolean
}

export const baseState: BaseState = {
    globalError: null,
    errors: null,
    isFormInProcess: false
};


abstract class AbstractForm<ChildProperties, ChildState> extends Component<ChildProperties & BaseProperties, ChildState & BaseState>{
    protected constructor(properties: ChildProperties & BaseProperties) {
        super(properties);

        // @ts-ignore
        this.state = baseState;
    }

    protected resetForm(state: any = {}) {
        this.setState({
            ...state,

            globalError: null,
            errors: null,
        });
    }

    protected processResponse(
        result: DefaultResponseResult,
        onSuccess: () => void,
        onUndefinedError: (error: string, errorType: string) => void
    ) {
        if (['error', 'output_error'].indexOf(result.type) >= 0) {
            const state: any = {};

            if (result.errors.length > 0) {
                state.globalError = null;

                state.errors = {};
                for (const error of result.errors) {
                    if (state.errors.hasOwnProperty(error.path)) {
                        state.errors[error.path] += ' ' + error.message;
                    } else {
                        state.errors[error.path] = error.message;
                    }
                }
            } else {
                onUndefinedError(result.message, result.type);
            }

            this.setState(state);
        } else {
            this.resetForm();

            onSuccess();
        }
    }
}

export default AbstractForm;
