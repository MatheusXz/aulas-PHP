
class Tabs extends React.Component {
    render() {
        return (
            <>
                <div class="col-md-3 col-12 my-3 d-flex align-items-center">
                    <div class="card">
                        <img src="https://fakeimg.pl/330x600?font=bebas" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <h5 class="card-title">Titulo</h5>
                                <p class="card-text">Autor</p>
                            </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 my-3 d-flex align-items-center">
                    <div class="card">
                        <img src="https://fakeimg.pl/330x600?font=bebas" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <h5 class="card-title">Titulo</h5>
                                <p class="card-text">Autor</p>
                            </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 my-3 d-flex align-items-center">
                    <div class="card">
                        <img src="https://fakeimg.pl/330x600?font=bebas" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <h5 class="card-title">Titulo</h5>
                                <p class="card-text">Autor</p>
                            </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 my-3 d-flex align-items-center">
                    <div class="card">
                        <img src="https://fakeimg.pl/330x600?font=bebas" class="card-img" alt="...">
                            <div class="card-img-overlay">
                                <h5 class="card-title">Titulo</h5>
                                <p class="card-text">Autor</p>
                            </div>
                    </div>
                </div>
            </>
        )
    }
}


const domContainer = document.querySelector('#tabs');
const root = ReactDOM.createRoot(domContainer);
root.render(e(Tabs));