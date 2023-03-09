import {Component} from 'preact';
import EntitySearchInput from "../components/Form/Search/EntitySearchInput";
import PageWrapper from "../components/Wrapper/PageWrapper";


interface Properties {}
interface State {}


export default class Home extends Component<Properties, State> {
    render() {
        return (
            <PageWrapper type={'full'}>
                <form class="py-6">
                    <EntitySearchInput />
                </form>
            </PageWrapper>
        );
    }
}
