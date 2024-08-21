import React from 'react';

const ShareOptionList = (props) => {
    const shareOptions = cirkle_vars.socialShareOptions;
    return (
        <div ref={props.forwardedRef} className="share-options">
            <ul className="share-list">
                {
                    shareOptions.map((item) => {
                        return (
                            <li key={item.id}>
                                <a target="_blank" href={item.url} className={item.class}>
                                    <i className={`icofont-${item.id}`}></i>
                                </a>
                            </li>
                        );
                    })
                }
            </ul>
        </div>
    );
};

const ShareOptionListForwardRef = React.forwardRef((props, ref) => {
    return (
        <ShareOptionList {...props} forwardedRef={ref}/>
    )
});

export default ShareOptionListForwardRef;
