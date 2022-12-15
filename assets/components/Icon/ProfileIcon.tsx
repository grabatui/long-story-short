import {Component} from 'preact';


type Properties = {};
type State = {};


export default class ProfileIcon extends Component<Properties, State> {
    render() {
        return (
            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="color:white">
                <circle cx="12" cy="8" r="5" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                <path d="M20 21C20 16.5817 16.4183 13 12 13C7.58172 13 4 16.5817 4 21" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                <path d="M20 21C20 16.5817 16.4183 13 12 13C7.58172 13 4 16.5817 4 21" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
        );
    }
};
