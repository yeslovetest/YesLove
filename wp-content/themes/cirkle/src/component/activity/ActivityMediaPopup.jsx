import React, {useRef, useLayoutEffect} from 'react';
import plugins from '../../helper/plugins';

const ActivityMediaPopup = (props) => {
    const {media} = props;
    const activityMediaPopupRef = useRef(null);
    const popup = useRef(null);
    useLayoutEffect(() => {
        popup.current = plugins.createPopup({
            triggerElement: props.activityMediaPopupTriggerRef.current,
            premadeContentElement: activityMediaPopupRef.current,
            type: 'premade',
            popupSelectors: ['activity-media-popup', 'animate-slide-down']
        });
    }, []);

    if ('video' === media.type) {
        if (media.is_remote && media.is_oembed && media.oembed.content) {
            return <div ref={activityMediaPopupRef} className="popup-video oembed"
                        dangerouslySetInnerHTML={{__html: ` ${media.oembed.content}`}}>
            </div>
        } else if (media.link) {
            return <div ref={activityMediaPopupRef} className="popup-video">
                <video src={media.link} controls/>
            </div>
        }

    } else if ('audio' === media.type) {
        return <div ref={activityMediaPopupRef} className="popup-audio">
            <audio src={media.link} controls/>
        </div>
    } else {
        return <div ref={activityMediaPopupRef} className="popup-picture">
            <div className="popup-picture-image-wrap">
                <img className="popup-picture-image" src={media.link}
                     alt={media.title}/>
            </div>
        </div>
    }
}

export default ActivityMediaPopup;