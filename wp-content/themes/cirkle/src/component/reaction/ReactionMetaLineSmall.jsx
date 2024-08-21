import React, {useState, useRef, useEffect, useLayoutEffect} from 'react';

import plugins from '../../helper/plugins';

import ReactionItemList from './ReactionItemList';
import ReactionBox from './ReactionBox';

const ReactionMetaLineSmall = (props) => {
    const [reactionBoxActiveTab, setReactionBoxActiveTab] = useState(0);
    const reactionBoxRef = useRef(null);
    const reactionBoxTriggerRef = useRef(null);

    useLayoutEffect(() => {
        plugins.createPopup({
            triggerElement: reactionBoxTriggerRef.current,
            premadeContentElement: reactionBoxRef.current,
            type: 'premade',
            popupSelectors: ['reaction-box-popup', 'animate-slide-down']
        });
    }, []);
    const activateFirstReactionBoxTab = () => {
        setReactionBoxActiveTab(0);
    };
    useEffect(() => {
        reactionBoxTriggerRef.current.addEventListener('mousedown', activateFirstReactionBoxTab);

        return () => {
            reactionBoxTriggerRef?.current?.removeEventListener('mousedown', activateFirstReactionBoxTab);
        };
    }, []);
    let reactionCount = 0;

    for (const reaction of props.data) {
        reactionCount += Number.parseInt(reaction.reaction_count, 10);
    }
    return (
        <div className="meta-line">
            <ReactionItemList modifiers='meta-line-list small'
                              data={props.data}
                              reactionCount={reactionCount}
            />

            <p ref={reactionBoxTriggerRef}
               className="meta-line-text meta-line-text-trigger">{reactionCount}</p>

            <ReactionBox forwardedRef={reactionBoxRef}
                         data={props.data}
                         reactionCount={reactionCount}
                         activeTab={reactionBoxActiveTab}
                         showTab={setReactionBoxActiveTab}
            />
        </div>
    );
}

export default ReactionMetaLineSmall;