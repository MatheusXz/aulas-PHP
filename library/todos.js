var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

import React from 'react';
import ReactDOM from 'react-dom';

var NavButton = function (_React$Component) {
    _inherits(NavButton, _React$Component);

    function NavButton() {
        _classCallCheck(this, NavButton);

        return _possibleConstructorReturn(this, (NavButton.__proto__ || Object.getPrototypeOf(NavButton)).apply(this, arguments));
    }

    _createClass(NavButton, [{
        key: 'render',
        value: function render() {
            var _props = this.props,
                text = _props.text,
                className = _props.className,
                onClick = _props.onClick;

            return React.createElement(
                'a',
                { className: className, href: '#', onClick: onClick },
                text
            );
        }
    }]);

    return NavButton;
}(React.Component);

var Navbar = function (_React$Component2) {
    _inherits(Navbar, _React$Component2);

    function Navbar() {
        _classCallCheck(this, Navbar);

        return _possibleConstructorReturn(this, (Navbar.__proto__ || Object.getPrototypeOf(Navbar)).apply(this, arguments));
    }

    _createClass(Navbar, [{
        key: 'handleAllClick',
        value: function handleAllClick() {
            return React.createElement(
                'div',
                null,
                'Teste'
            );
        }
    }, {
        key: 'handleCategoryClick',
        value: function handleCategoryClick() {
            // Handle 'Category' button click
        }
    }, {
        key: 'render',
        value: function render() {
            return React.createElement(
                'div',
                { className: 'row' },
                React.createElement(
                    'div',
                    { className: 'd-flex align-items-center' },
                    React.createElement(
                        'nav',
                        { className: 'nav nav-pills' },
                        React.createElement(NavButton, {
                            text: 'Todos',
                            className: 'nav-link text-white fw-bolder text-decoration-underline',
                            onClick: this.handleAllClick
                        }),
                        React.createElement(NavButton, {
                            text: 'Categoria',
                            className: 'nav-link text-white-50 mx-2',
                            onClick: this.handleCategoryClick
                        }),
                        React.createElement(NavButton, {
                            text: 'Autor',
                            className: 'nav-link text-white-50 mx-2'
                        }),
                        React.createElement(NavButton, {
                            text: 'Language',
                            className: 'nav-link disabled'
                        })
                    )
                )
            );
        }
    }]);

    return Navbar;
}(React.Component);

ReactDOM.render(React.createElement(Navbar, null), document.getElementById('root'));

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