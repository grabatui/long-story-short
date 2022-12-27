import {connect} from 'unistore/preact';
import {userActions} from '../actions/userActions';
import {Component} from 'preact';
import {StoreStateInterface} from '../types';
import Loader from './Loader';


interface Properties extends StoreStateInterface {
    loadUserToken(): void;
    loadUserAction(): void;
}
interface State {
    isInitiated: boolean,
}


class Wrapper extends Component<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            isInitiated: false,
        };
    }

    componentDidMount() {
        this.init().then(
            () => this.setState({isInitiated: true})
        );
    }

    private async init() {
        if (this.state.isInitiated) {
            return;
        }

        await this.props.loadUserToken();

        return Promise.all([
            await this.props.loadUserAction(),
        ]);
    }

    render() {
        if (!this.state.isInitiated) {
            return <Loader size={10} />
        }

        return this.props.children;
    }
}


export default connect([], userActions)(Wrapper);