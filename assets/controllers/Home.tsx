import {Component} from 'preact';
import SearchInput from "../components/Form/Search/SearchInput";
import PageWrapper from "../components/Wrapper/PageWrapper";


interface Properties {}
interface State {}


export default class Home extends Component<Properties, State> {
    render() {
        return (
            <PageWrapper type={'full'}>
                <form class="py-6">
                    <SearchInput />
                </form>
            </PageWrapper>
        );
    }
}
