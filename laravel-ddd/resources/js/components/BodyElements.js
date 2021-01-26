import React, {useState} from 'react';
import ReactDOM from 'react-dom';
import {ToastContainer, toast} from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

import {Dialog} from "@reach/dialog";
import "@reach/dialog/styles.css";
import VisuallyHidden from "@reach/visually-hidden";

const BodyElements = () => {
    const [showDialog, setShowDialog] = useState(false);
    const open = () => {
        setShowDialog(true);
    }
    const close = () => setShowDialog(false);

    const testToastify = () => {
        toast('Это тостер!');
    }

    return (
        <div>

            <ToastContainer/>

            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Кнопки для интерактива</div>

                            <div className="card-body">
                                <button className="btn btn-dark mr-4" onClick={open}>Dialog</button>
                                <button className="btn btn-dark" onClick={() => testToastify()}>Toastify</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Dialog aria-label="Warning about next steps" isOpen={showDialog} onDismiss={close}>
                <button className="close-button btn" onClick={close}>
                    <VisuallyHidden>Close</VisuallyHidden>
                    <span aria-hidden>×</span>
                </button>

                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Popup</div>

                            <div className="card-body">
                                Текст попапа
                            </div>
                        </div>
                    </div>
                </div>

            </Dialog>
        </div>
    );
}

export default BodyElements;

if (document.getElementById('bodyElements')) {
    ReactDOM.render(<BodyElements/>, document.getElementById('bodyElements'));
}
