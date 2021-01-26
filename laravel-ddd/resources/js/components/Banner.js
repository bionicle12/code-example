import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import "react-responsive-carousel/lib/styles/carousel.min.css";
import { Carousel } from 'react-responsive-carousel';

const Banner = (props) => {
    const [images, setImages] = useState([]);

    const id = props.id;
    const url = `/api/banners/${id}`;

    useEffect(() => {

        const getBannerById = async () => {
            try {
                await axios.get(
                    url
                )
                    .then((res) => {
                        console.log(res.data);
                        // let data = [];
                        // res.data.map(function(item){
                        //     data.push({
                        //         'image': item.image,
                        //         'caption': item.text
                        //     });
                        // });
                        setImages(res.data);
                    });
            } catch (error) {
                console.log(error);
            }
        }
        getBannerById();

    }, []);

    return (
        <>
            {images.length > 0 ? (
                <Carousel
                    showArrows={false}
                    showThumbs={false}
                    showStatus={false}
                    showIndicators={false}
                    autoPlay={true}
                    dynamicHeight={true}
                    transitionTime={2000}
                    interval={3000}
                    swipeScrollTolerance={5}
                    infiniteLoop={true}
                    swipeable={true}
                    emulateTouch={true}
                    stopOnHover={true}
                    >
                    {
                        images.map((item, index) => (
                        <div key={index}>
                            <a href={item.link}>
                                <img
                                    src={item.image}
                                    alt={item.text}
                                />
                            </a>
                        </div>
                        ))
                    }
                </Carousel>
            ) : null }

        </>
    );
}

export default Banner;

document.querySelectorAll('.banner')
    .forEach(domContainer => {
        const id = domContainer.dataset.id;
        ReactDOM.render(
            React.createElement(Banner, {id: id}),
            domContainer
        );
    });
