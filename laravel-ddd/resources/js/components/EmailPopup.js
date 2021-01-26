import React, {useState} from 'react';
import ReactDOM from "react-dom";

import {Dialog} from "@reach/dialog";
import "@reach/dialog/styles.css";

const EmailPopup = (props) => {
    const [showDialog, setShowDialog] = useState(false);
    const open = () => {
        setShowDialog(true);
    }
    const close = () => setShowDialog(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('Save contacts form');
    };

    return (
        <div>

            <div
                className={props.className}
                onClick={open}
            >{props.text}</div>

            <Dialog aria-label="Email us form" isOpen={showDialog} onDismiss={close}>
                <button className="close-button btn" onClick={close}>
                    <span aria-hidden>×</span>
                </button>

                <form className="d-flex flex-column" onSubmit={handleSubmit}>
                    <div className="form-group">
                        <label htmlFor="message">Your message *</label>
                        <textarea id="message" className="form-control"></textarea>
                    </div>
                    <div className="form-group d-flex">
                        <div className="flex-fill mr-3">
                            <label htmlFor="name">Name *</label>
                            <input className="form-control" id="name" name="name" />
                        </div>
                        <div className="flex-fill">
                            <label htmlFor="country">Country *</label>
                            <input className="form-control" id="country" />
                        </div>
                    </div>
                    <div className="form-group d-flex">
                        <div className="flex-fill mr-3">
                            <label htmlFor="email">E-mail *</label>
                            <input className="form-control" id="email" />
                        </div>
                        <div className="flex-fill">
                            <label htmlFor="phone">Phone</label>
                            <input className="form-control" id="phone" />
                        </div>
                    </div>
                    <div className="text-center mb-3">
                        <button className="btn-send" type="submit">Send</button>
                    </div>
                    <div className="text-center mb-5">
                        By pressing the «Send» button you give your consent to processing your personal data
                    </div>
                </form>
            </Dialog>

        </div>
    );
};

export default EmailPopup;

document.querySelectorAll('.EmailPopup')
    .forEach(domContainer => {
        const text = domContainer.dataset.text;
        ReactDOM.render(
            React.createElement(EmailPopup, { className: "email-link", text: text }),
            domContainer
        );
    });
