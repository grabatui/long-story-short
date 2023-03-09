import {Component} from 'preact';
import PageWrapper from "../components/Wrapper/PageWrapper";


interface Properties {
    slug?: string
}
interface State {}


export default class Movie extends Component<Properties, State> {
    render() {
        return (
            <PageWrapper type={'full'}></PageWrapper>
        );
    }
}
