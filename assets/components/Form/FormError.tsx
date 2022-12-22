import {Component} from 'preact';


interface Properties {
    error: string|null,
}
interface State {}


export default class FormError extends Component<Properties, State> {
    render() {
        return this.props.error && (
            <span className="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">{this.props.error}</span>
        )
    }
};
