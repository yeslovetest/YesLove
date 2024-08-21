import React, {useRef} from 'react';

import ActivityMediaPopup from '../activity/ActivityMediaPopup';

const PhotoPreview = (props) => {
    const activityMediaPopupTriggerRef = useRef(null);
    const media = props.data;
    return (
        <div className="photo-preview-wrap">
            <div className={`photo-preview ${props.modifiers || ''}`}>
                {
                    media.type === 'video' && media.is_remote && media.is_oembed && media.oembed.thumbnail &&
                    <div className="photo-preview-image video oembed"
                         dangerouslySetInnerHTML={{__html: ` ${media.oembed.thumbnail}`}}>
                    </div>
                }
                {
                    media.type === 'video' && !media.is_oembed && media.link &&
                    <div className="photo-preview-image video">
                        <video src={media.link}/>
                    </div>
                }
                {
                    media.type === 'photo' &&
                    <div className="photo-preview-image"
                         style={{background: `url('${media.link}') center center / cover no-repeat`}}/>
                }

                <div ref={activityMediaPopupTriggerRef} className="photo-preview-info"/>
            </div>

            {
                !(props.noPopup) &&
                <div>
                    <ActivityMediaPopup media={media}
                                        activityMediaPopupTriggerRef={activityMediaPopupTriggerRef}
                    />
                </div>
            }
        </div>
    );
}

export default PhotoPreview;