import React, {useRef, useLayoutEffect} from 'react';
import plugins from '../../helper/plugins';

import LoaderSpinnerSmall from '../loader/LoaderSpinnerSmall';

const ActivitySettings = (props) => {
    const settingsDropdownTriggerRef = useRef(null);
    const settingsDropdownContentRef = useRef(null);

    useLayoutEffect(() => {
        plugins.createDropdown({
            triggerElement: settingsDropdownTriggerRef.current,
            containerElement: settingsDropdownContentRef.current,
            offset: {
                top: 30,
                right: 9
            },
            animation: {
                type: 'translate-top',
                speed: .3,
                translateOffset: {
                    vertical: 20
                }
            }
        });
    }, []);

    return (
        <div className="widget-box-settings">
            <div className="post-settings-wrap">
                <div ref={settingsDropdownTriggerRef} className="post-settings">
                    <i className="icofont-listine-dots"></i>
                </div>

                <div ref={settingsDropdownContentRef} className="simple-dropdown">
                    {
                        !props.favorite &&
                        <div className="simple-dropdown-link"
                             onClick={props.addFavorite}>{cirkle_lng.add_favorite} {props.processingFavorite &&
                        <LoaderSpinnerSmall/>}</div>
                    }
                    {
                        props.favorite &&
                        <div className="simple-dropdown-link"
                             onClick={props.removeFavorite}>{cirkle_lng.remove_favorite} {props.processingFavorite &&
                        <LoaderSpinnerSmall/>}</div>
                    }
                    {
                        props.userIsActivityAuthor && !props.pinned &&
                        <div className="simple-dropdown-link"
                             onClick={props.pinActivity}>{cirkle_lng.pin_to_top} {props.processingPinned &&
                        <LoaderSpinnerSmall/>}</div>
                    }
                    {
                        props.userIsActivityAuthor && props.pinned &&
                        <div className="simple-dropdown-link"
                             onClick={props.unpinActivity}>{cirkle_lng.unpin_from_top} {props.processingPinned &&
                        <LoaderSpinnerSmall/>}</div>
                    }
                    {
                        props.userCanDeleteActivity &&
                        <div className="simple-dropdown-link"
                             onClick={(e) => {
                                 if (confirm(cirkle_lng.delete_activity_message_text)) {
                                     props.deleteActivity();
                                 }
                             }}>{cirkle_lng.delete_post} {props.processingDelete &&
                        <LoaderSpinnerSmall/>}</div>
                    }
                </div>
            </div>
        </div>
    );
}

export default ActivitySettings;