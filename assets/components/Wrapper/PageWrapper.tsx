import {Component} from 'preact';
import {classNames} from '../../helpers';


interface Properties {
    title?: string,
    type: 'full'|'form'
}
interface State {}


export default class PageWrapper extends Component<Properties, State> {
    private getWidthClassName(): string {
        switch (this.props.type) {
            case 'full':
                return 'max-w-7xl';

            case 'form':
                return 'max-w-2xl';
        }
    }

    render() {
        return (
            <div
                className={classNames([
                    'mx-auto px-2 sm:px-6 lg:px-8',
                    this.getWidthClassName()
                ])}
            >
                {this.props.title && <h1 className="font-medium text-3xl py-6">{this.props.title}</h1>}

                {this.props.children}
            </div>
        );
    }
}
