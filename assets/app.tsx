import './styles/app.css';

import Router from 'preact-router';
import {Component, render} from 'preact';
import {Provider} from 'unistore/preact';
import Header from './components/Header';
import Home from './controllers/Home';
import Series from './controllers/Series';
import {store} from './store'
import LoginModal from './components/Modal/LoginModal';
import RegistrationModal from './components/Modal/RegistrationModal';
import ProfileIndex from './controllers/Profile/ProfileIndex';
import Wrapper from './components/Wrapper';
import RestorePasswordModal from './components/Modal/RestorePasswordModal';
import ResetPassword from './controllers/Profile/ResetPassword';


type Properties = {}
type State = {}


class App extends Component<Properties, State> {
    render() {
        return (
            <Wrapper>
                <Header />

                <Router>
                    <Home path="/" />
                    <Series path="/series" />

                    <ProfileIndex path="/profile" />
                    <ResetPassword path="/profile/reset-password/:token" />
                </Router>

                <LoginModal />
                <RegistrationModal />
                <RestorePasswordModal />
            </Wrapper>
        );
    }
}

render(
    <Provider store={store}>
        <App />
    </Provider>,
    document.getElementById('app')
);
