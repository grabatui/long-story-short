import {Component} from 'preact';
import PageWrapper from '../components/Wrapper/PageWrapper';
import SearchInput from '../components/Form/Search/SearchInput';


interface Properties {}
interface State {}


export default class Series extends Component<Properties, State> {
    render() {
        return (
            <PageWrapper type={'full'}>
                <form class="py-6">
                    {/* @ts-ignore */}
                    <SearchInput strictType={'series'} />
                </form>
            </PageWrapper>
        );
    }
}
