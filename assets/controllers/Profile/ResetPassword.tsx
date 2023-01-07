import {Component} from 'preact';


type Properties = {
    token?: string
}
type State = {}


export default class ResetPassword extends Component<Properties, State> {
    render() {
        if (!this.props.token) {
            // TODO: Redirect to 404
        }

        return (
            <div>Lets reset password!</div>
        );
    }
}
