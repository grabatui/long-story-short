import {Component} from 'preact';
import PageWrapper from '../components/Wrapper/PageWrapper';
import EntitySearchInput from '../components/Form/Search/EntitySearchInput';


interface Properties {}
interface State {}


export default class Movies extends Component<Properties, State> {
    render() {
        return (
            <PageWrapper type={'full'}>
                <form class="py-6">
                    {/* @ts-ignore */}
                    <EntitySearchInput strictType={'movies'} />
                </form>
            </PageWrapper>
        );
    }
}
