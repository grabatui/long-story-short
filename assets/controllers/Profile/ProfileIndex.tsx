import {Component} from 'preact';
import {StoreStateInterface} from '../../types';
import {connect} from 'unistore/preact';
import {route} from 'preact-router';


interface Properties extends StoreStateInterface {}
interface State {}


class ProfileIndex extends Component<Properties, State> {
    render() {
        if (this.props.user.type === 'unauthorized') {
            setTimeout(() => route('/', true), 100);

            return;
        }

        return (
            <div>Hello profile page!</div>
        );
    }
}

export default connect(['user'])(ProfileIndex);
