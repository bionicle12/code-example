import React, {useState} from 'react';
import ReactDOM from 'react-dom';

const ScrollUp = () => {
    const [showScroll, setShowScroll] = useState(false);

    const scrollToTop = () => {
        window.scrollTo({top: 0, left: 0, behavior: 'smooth' });
    };

    const checkScrollTop = () => {
        if (!showScroll && window.pageYOffset > 400) {
            setShowScroll(true);
        } else if (showScroll && window.pageYOffset <= 400) {
            setShowScroll(false);
        }
    };

    window.addEventListener('scroll', checkScrollTop);

    return (
        <div
            title="To Top"
            className="scroll"
            onClick={() => scrollToTop()}
            style={{display: showScroll ? 'flex' : 'none'}}
        >
            <img src="/images/up.svg" alt=""/>
        </div>
    );
}

if (document.getElementById('scrollUp')) {
    ReactDOM.render(<ScrollUp/>, document.getElementById('scrollUp'));
}
