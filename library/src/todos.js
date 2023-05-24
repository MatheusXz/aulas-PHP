import React from 'react';
import ReactDOM from 'react-dom';

class NavButton extends React.Component {
    render() {
        const { text, className, onClick } = this.props;
        return (
            <a className={className} href="#" onClick={onClick}>
                {text}
            </a>
        );
    }
}

class Navbar extends React.Component {
    handleAllClick() {
        return (
            <div>Teste</div>
        )
    }

    handleCategoryClick() {
        // Handle 'Category' button click
    }

    render() {
        return (
            <div className="row">
                <div className="d-flex align-items-center">
                    <nav className="nav nav-pills">
                        <NavButton
                            text="Todos"
                            className="nav-link text-white fw-bolder text-decoration-underline"
                            onClick={this.handleAllClick}
                        />
                        <NavButton
                            text="Categoria"
                            className="nav-link text-white-50 mx-2"
                            onClick={this.handleCategoryClick}
                        />
                        <NavButton
                            text="Autor"
                            className="nav-link text-white-50 mx-2"
                        />
                        <NavButton
                            text="Language"
                            className="nav-link disabled"
                        />
                    </nav>
                </div>
            </div>
        );
    }
}

ReactDOM.render(<Navbar />, document.getElementById('root'));

// class All extends React.Component {
//     render() {
//         return (
//             <div className="row">
//                 <div className="col-md-3 col-12 my-3 d-flex align-items-center">
//                     <div className="card">
//                         <img
//                             src="https://fakeimg.pl/330x600?font=bebas"
//                             className="card-img"
//                             alt="..."
//                         />
//                         <div className="card-img-overlay">
//                             <h5 className="card-title">Titulo</h5>
//                             <p className="card-text">Autor</p>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         );
//     }
// }

// class Category extends React.Component {
//     render() {
//         return (
//             <div className="row">
//                 <div className="col-md-3 col-12 my-3 d-flex align-items-center">
//                     <div className="card">
//                         <img
//                             src="https://fakeimg.pl/330x600?font=bebas"
//                             className="card-img"
//                             alt="..."
//                         />
//                         <div className="card-img-overlay">
//                             <h5 className="card-title">Titulo</h5>
//                             <p className="card-text">Autor</p>
//                         </div>
//                     </div>
//                 </div>
//                 <div className="col-md-3 col-12 my-3 d-flex align-items-center">
//                     <div className="card">
//                         <img
//                             src="https://fakeimg.pl/330x600?font=bebas"
//                             className="card-img"
//                             alt="..."
//                         />
//                         <div className="card-img-overlay">
//                             <h5 className="card-title">Titulo</h5>
//                             <p className="card-text">Autor</p>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         );
//     }
// }

// class NavButton extends React.Component {

//     render() {
//         const { text, className, onClick } = this.props;
//         return (
//             <a className={className} href="#" onClick={onClick}>
//                 {text}
//             </a>
//         );
//     }
// }

