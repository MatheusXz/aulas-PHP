class Category extends React.Component {
    render() {
        return (
            <>
                <div className="row my-5">
                    <div className="col-md-2">
                        <img
                            src="https://fakeimg.pl/130x100/"
                            style={{ borderRadius: '10px' }}
                            className=""
                            alt="..."
                        />
                    </div>
                    <div className="col-md-8">
                        <div className="text">
                            <h5 className="text-white">Titulo</h5>
                            <p className="text-white-50">Autor</p>
                            <p className="text-white-50 text-truncate">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis dolores architecto tempora nisi quia amet, quam aspernatur possimus, corrupti itaque repellendus perferendis ullam asperiores nobis veniam ex earum temporibus illo?
                            </p>
                        </div>
                    </div>

                    <div className="col-md-2 d-flex justify-content-end align-self-center">
                        <a className="btn btn-block btn-secondary" href="#!">
                            <i className="fa-solid fa-plus" style={{ color: '#ffffff' }}></i>
                        </a>
                    </div>
                </div>
                <hr />
            </>
        );
    }
}

export default Category;