import './styles/app.css';

import Router, {route, RouterOnChangeArgs} from 'preact-router';
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
import Error404 from './controllers/Error404';


type Properties = {}
type State = {}


const handleRoute = (routeItem: RouterOnChangeArgs) => {
    if (!routeItem.current) {
        setTimeout(() => route('/404', false), 100);
    }
};


class App extends Component<Properties, State> {
    render() {
        return (
            <Wrapper>
                <Header />

                <Router onChange={handleRoute}>
                    <Home path="/" />
                    <Series path="/series" />

                    <ProfileIndex path="/profile" />
                    <ResetPassword path="/profile/reset-password/:resetToken" />

                    <Error404 path="/404" />
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
