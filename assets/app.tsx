import './styles/app.css';

import Router from 'preact-router';
import {Component, h, render} from 'preact';
import Header from "./components/Header";
import Home from "./controllers/Home";
import Series from "./controllers/Series";


type Properties = {}
type State = {}


class App extends Component<Properties, State> {
    render() {
        console.log();

        return (
            <Component>
                <Header />

                <Router>
                    <Home path="/" />
                    <Series path="/series" />
                </Router>
            </Component>
        );
    }
}

render(<App />, document.getElementById('app'));
