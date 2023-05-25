class NavButton extends React.Component {
    render() {
        const { text, className, isActive, onClick } = this.props;
        const buttonClass = isActive ? `${className} text-white fw-bolder text-decoration-underline` : `${className} text-white-50`;

        return (
            <button className={buttonClass} onClick={onClick}>
                {text}
            </button>
        );
    }
}
export default NavButton;