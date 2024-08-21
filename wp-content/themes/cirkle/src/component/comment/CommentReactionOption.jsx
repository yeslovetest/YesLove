import React, {useEffect, useRef} from 'react';

import plugins from '../../helper/plugins';

import ReactionOptionList from '../reaction/ReactionOptionList';

const CommentReactionOption =(props)=> {
    const reactionOptionsDropdownTriggerRef = useRef(null);
    const reactionOptionsDropdownContentRef = useRef(null);
    useEffect(() => {
        plugins.createDropdown({
            triggerElement: reactionOptionsDropdownTriggerRef.current,
            containerElement: reactionOptionsDropdownContentRef.current,
            triggerEvent: 'hover',
            offset: {
                bottom: 30,
                left: -80
            },
            animation: {
                type: 'translate-bottom',
                speed: .3,
                translateOffset: {
                    vertical: 16
                }
            },
            closeOnDropdownClick: true
        });
    }, []);
    return (
        <div className="meta-line">
            <div ref={reactionOptionsDropdownTriggerRef}
                 className="meta-line-link-wrap" {...(props.userReaction && {onClick: props.deleteUserReaction})}>
                {
                    !props.userReaction &&
                    <p className="meta-line-link light">{cirkle_lng.react}</p>
                }
                {
                    props.userReaction &&
                    <p className="meta-line-link light">{props.userReaction.name}</p>
                }
            </div>

            <ReactionOptionList ref={reactionOptionsDropdownContentRef} modifiers='small'
                                data={props.reactions} createUserReaction={props.createUserReaction}/>
        </div>
    );
}

export default CommentReactionOption;