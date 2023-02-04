import {Component} from 'preact';
import {connect} from 'unistore/preact';
import {SearchTypeInterface, StoreStateInterface} from '../../../types';
import {classNames} from "../../../helpers";
import OutsideClickWrapper from "../../Wrapper/OutsideClickWrapper";


interface Properties extends StoreStateInterface {
    strictType?: string
}
interface State {
    type?: SearchTypeInterface,
    isTypeSelectShown: boolean,
    searchValue: string|null,
}


class SearchInput extends Component<Properties, State> {
    constructor(properties: Properties) {
        super(properties);

        this.state = {
            type: this.resolveInitType(),
            isTypeSelectShown: false,
            searchValue: null,
        };
    }

    private resolveInitType(): SearchTypeInterface {
        if (this.props.strictType) {
            const searchType = this.props.initData.search_types.find(
                (searchType: SearchTypeInterface): boolean => searchType.type === this.props.strictType
            );

            if (searchType) {
                return searchType;
            }
        }

        const [firstSearchType] = this.props.initData.search_types;

        return firstSearchType;
    }

    private onTypeSelect(type: SearchTypeInterface): void {
        this.setState({type: type})

        this.closeTypeSelect();
    }

    private switchTypeSelect() {
        this.setState({isTypeSelectShown: !this.state.isTypeSelectShown});
    }

    private closeTypeSelect() {
        this.setState({isTypeSelectShown: false});
    }

    private onSelectInput(event: Event) {
        const target = event.currentTarget;

        if (!(target instanceof HTMLInputElement)) {
            return;
        }

        this.setState({searchValue: target.value});

        // TODO: Start search
    }

    render() {
        return (
            <div className="flex">
                <label
                    htmlFor="search-dropdown"
                    className="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                >Поиск</label>

                {!this.props.strictType && (
                    <OutsideClickWrapper onOutsideClick={() => this.closeTypeSelect()}>
                        <button
                            id="dropdown-button"
                            data-dropdown-toggle="dropdown"
                            className="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                            type="button"
                            onClick={() => this.switchTypeSelect()}
                        >{this.state.type.title} <svg aria-hidden="true" className="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        </button>

                        <div
                            id="dropdown"
                            className={classNames([
                                'z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700',
                                this.state.isTypeSelectShown ? 'block' : 'hidden'
                            ])}
                            style="position: absolute; margin: 0px;"
                        >
                            <ul
                                className="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdown-button"
                            >
                                {this.props.initData.search_types.map(
                                    (searchType: SearchTypeInterface) => <li>
                                        <button
                                            type="button"
                                            className="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            onClick={() => this.onTypeSelect(searchType)}
                                        >{searchType.title}</button>
                                    </li>
                                )}
                            </ul>
                        </div>
                    </OutsideClickWrapper>
                )}

                <div className="relative w-full">
                    <input
                        type="search"
                        id="search-dropdown"
                        className={classNames([
                            'block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500',
                            this.props.strictType
                                ? 'rounded-lg'
                                : 'rounded-r-lg border-l-gray-50 border-l-2 dark:border-l-gray-700'
                        ])}
                        placeholder={this.state.type.placeholder}
                        value={this.state.searchValue}
                        onInput={(event:Event) => this.onSelectInput}
                        required
                    />

                    <button
                        type="submit"
                        className="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 20L15.9497 15.9497M15.9497 15.9497C17.2165 14.683 18 12.933 18 11C18 7.13401 14.866 4 11 4C7.13401 4 4 7.13401 4 11C4 14.866 7.13401 18 11 18C12.933 18 14.683 17.2165 15.9497 15.9497Z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>

                        <span className="sr-only">Search</span>
                    </button>
                </div>
            </div>
        );
    }
}

export default connect(['initData'])(SearchInput);
