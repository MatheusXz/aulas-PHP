import All from './All';
import Autor from './Autor';
import Category from './Category';
import NavButton from './NavButton';

class Navbar extends React.Component {
    teste = ''; // Variável global

    constructor(props) {
        super(props);
        this.state = {
            teste: '',
            activeButton: 'Todos',
        };
    }

    handleNavButtonClick = (value) => {
        this.setState({ activeButton: value });
        this.setState({ teste: value });

        this.teste = value; // Atualiza a variável global
        
        if (this.teste === "Todos") {
            ReactDOM.render(<All />, document.getElementById('allBooksContainer'));
        } else if (this.teste === "Categoria") {
            ReactDOM.render(<Category />, document.getElementById('allBooksContainer'));
        } else if (this.teste === "Autor") {
            ReactDOM.render(<Autor />, document.getElementById('allBooksContainer'));
        }
        
    }
    
    render() {
        const { activeButton } = this.state;
        return (
            <div className="row">
                <div className="d-flex">
                    <nav className="nav">
                        <NavButton
                            text="Todos"
                            className="nav-link mx-2"
                            isActive={activeButton === 'Todos'}
                            onClick={() => this.handleNavButtonClick('Todos')}
                        />
                        <NavButton
                            text="Categoria"
                            className="nav-link mx-2"
                             isActive={activeButton === 'Categoria'}
                            onClick={() => this.handleNavButtonClick('Categoria')}
                        />
                        <NavButton
                            text="Autor"
                            className="nav-link mx-2"
                             isActive={activeButton === 'Autor'}
                            onClick={() => this.handleNavButtonClick('Autor')}
                        />
                        
                    </nav>
                </div>
            </div>
        );
    }

}
ReactDOM.render(<All />, document.getElementById('allBooksContainer'));

export default Navbar;