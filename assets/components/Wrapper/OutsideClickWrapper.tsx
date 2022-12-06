import {Component, h, createRef} from 'preact';


type Properties = {
    onOutsideClick: any
};
type State = {};


export default class OutsideClickWrapper extends Component<Properties, State> {
    wrapperRef = createRef();

    componentDidMount() {
        document.addEventListener('mousedown', this.handleClickOutside.bind(this));
    }

    componentWillUnmount() {
        document.removeEventListener('mousedown', this.handleClickOutside.bind(this));
    }

    handleClickOutside(event: any) {
        if (
            this.wrapperRef.current
            && !this.wrapperRef.current.contains(event.target)
        ) {
            this.props.onOutsideClick();
        }
    }

    render() {
        return (
            <div ref={this.wrapperRef}>
                {this.props.children}
            </div>
        );
    }
};
