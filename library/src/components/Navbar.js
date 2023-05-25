import All from './All';
import Autor from './Autor';
import Category from './Category';
import NavButton from './NavButton';

class Navbar extends React.Component {
    teste = ''; // Variável global

    constructor(props) {
        super(props);
        this.state = {
            teste: ''
        };
    }

    handleNavButtonClick = (value) => {
        this.teste = value; // Atualiza a variável global
        this.setState({ teste: value });
        console.log('Valor armazenado:', value);


        if (this.teste === "Todos") {
            ReactDOM.render(<All />, document.getElementById('allBooksContainer'));
        } else if (this.teste === "Categoria") {
            ReactDOM.render(<Category />, document.getElementById('allBooksContainer'));
        } else if (this.teste === "Autor") {
            ReactDOM.render(<Autor />, document.getElementById('allBooksContainer'));
        }

    }

    render() {
        return (
            <div className="row">
                <div className="d-flex">
                    <nav className="nav">
                        <NavButton
                            text="Todos"
                            className="nav-link text-white text-decoration-underline"
                            onClick={() => this.handleNavButtonClick('Todos')}
                        />
                        <NavButton
                            text="Categoria"
                            className="nav-link text-white-50 mx-2"
                            onClick={() => this.handleNavButtonClick('Categoria')}
                        />
                        <NavButton
                            text="Autor"
                            className="nav-link text-white-50 mx-2"
                            onClick={() => this.handleNavButtonClick('Autor')}
                        />
                        <NavButton
                            text="Language"
                            className="nav-link disabled"
                            onClick={() => this.handleNavButtonClick('Language')}
                        />
                    </nav>
                </div>
            </div>
        );
    }

}
ReactDOM.render(<All />, document.getElementById('allBooksContainer'));

export default Navbar;