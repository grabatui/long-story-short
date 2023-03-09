import {Component} from 'preact';
import {connect} from 'unistore/preact';
import {EntitiesInterface, EntityInterface, SearchTypeInterface, StoreStateInterface} from '../../../types';
import {classNames} from '../../../helpers';
import OutsideClickWrapper from '../../Wrapper/OutsideClickWrapper';
import {entitySearch} from "../../../repository/entitySearch";
import Loader from "../../Loader";
import getCountryFlag from "country-flag-icons/unicode";


interface Properties extends StoreStateInterface {
    strictType?: string,
}
interface State {
    type?: SearchTypeInterface,
    isTypeSelectShown: boolean,
    isInSearch: boolean|null,
    searchValue: string|null,
    searchItems: EntitiesInterface|null
}


class EntitySearchInput extends Component<Properties, State> {
    controller?: AbortController;
    selectInputTimeout?: NodeJS.Timeout;

    constructor(properties: Properties) {
        super(properties);

        this.controller = null;

        this.state = {
            type: this.resolveInitType(),
            isTypeSelectShown: false,
            isInSearch: null,
            searchValue: null,
            searchItems: null
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

    private async onSelectInput(event: Event) {
        const target = event.currentTarget;

        if (!(target instanceof HTMLInputElement)) {
            return;
        }

        this.setState({
            searchValue: target.value,
            isInSearch: true,
        });

        clearTimeout(this.selectInputTimeout);
        this.selectInputTimeout = setTimeout(
            async () => {
                try {
                    this.setState({searchItems: null});

                    this.controller?.abort();
                    this.controller = new AbortController();

                    const response = await entitySearch(target.value, this.controller.signal, this.state.type.type);

                    this.setState({
                        isInSearch: false,
                        searchItems: response.data
                    });
                } catch (error: any) {
                    if (process.env.NODE_ENV !== 'production') {
                        console.error(error)
                    }

                    this.setState({
                        isInSearch: false,
                        searchItems: null
                    });
                }
            },
            700
        );
    }

    private renderSearchItems() {
        if (this.state.isInSearch) {
            return <Component>
                <div id="dropdownNotification" className="z-20 w-full bg-white divide-y divide-gray-100 rounded-b-lg shadow dark:bg-gray-800 dark:divide-gray-700">
                    <div className="divide-y divide-gray-100 dark:divide-gray-700 p-2.5">
                        <Loader fullScreen={false} />
                    </div>
                </div>
            </Component>
        }

        if (!this.state.searchItems || this.state.searchItems.items.length <= 0) {
            if (this.state.searchValue && this.state.searchValue.length > 0) {
                return <Component>
                    <div id="dropdownNotification" className="z-20 w-full bg-white divide-y divide-gray-100 rounded-b-lg shadow dark:bg-gray-800 dark:divide-gray-700">
                        <div className="text-sm divide-y divide-gray-100 dark:divide-gray-700 p-2.5 cursor-default">Ничего не найдено. Попробуйте уточнить поиск</div>
                        {/* TODO: Добавить кнопку типа "Или добавьте новый фильм" */}
                    </div>
                </Component>
            }

            return <Component />
        }

        return <div className="rounded-b-lg shadow">
            {this.state.searchItems.items.map((entity: EntityInterface) => <Component>
                <div id="dropdownNotification" className="z-20 w-full bg-white divide-y divide-gray-100 dark:bg-gray-800 dark:divide-gray-700">
                    <div className="divide-y divide-gray-100 dark:divide-gray-700">
                        <a href={entity.url} className="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div className="flex-shrink-0">
                                <img className="h-11" src={entity.poster} alt={entity.title + ' (' + entity.original_title + ')'} />
                            </div>

                            <div className="w-full pl-3">
                                <div className="font-semibold text-sm text-gray-900 dark:text-white">
                                    {entity.title}{entity.original_title && <span className="text-gray-500 dark:text-gray-400"> ({entity.original_title})</span>}
                                </div>

                                <div className="text-xs text-gray-500 dark:text-gray-400">
                                    {entity.premiered_year} | {this.renderEntityGenres(entity.genres)} | {this.renderEntityCountries(entity.countries)}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </Component>)}
        </div>
    }

    private renderEntityGenres(genres: string[]) {
        return <Component>{genres.slice(0, 3).join(', ')}{genres.length > 3 && <Component>&hellip;</Component>}</Component>;
    }

    private renderEntityCountries(countries: string[]) {
        return countries.map((country: string) => getCountryFlag(country))
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
                        type="text"
                        id="search-dropdown"
                        className={classNames([
                            'block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500',
                            this.props.strictType
                                ? 'rounded-lg'
                                : 'rounded-r-lg border-l-gray-50 border-l-2 dark:border-l-gray-700'
                        ])}
                        placeholder={this.state.type.placeholder}
                        value={this.state.searchValue}
                        onInput={(event) => this.onSelectInput(event)}
                        autocomplete="off"
                        required
                    />

                    {this.renderSearchItems()}
                </div>
            </div>
        );
    }
}

export default connect(['initData'])(EntitySearchInput);
