import React, {useState, useRef, useEffect, useLayoutEffect} from 'react';

import app from "../../helper/core";
import ActivityMedia from "../activity/ActivityMedia";
import PostActivityPreview from "./PostActivityPreview";
import ReactionBox from "../reaction/ReactionBox";
import plugins from "../../helper/plugins";

const PostBody = (props) => {
    const [reactionBoxActiveTab, setReactionBoxActiveTab] = useState(0);

    const [reactionData, setReactionData] = useState(props.reactionData);
    const [userReaction, setUserReactions] = useState(false);

    const reactionBoxRef = useRef(null);
    const reactionBoxTriggerRef = useRef(null);
    const getUserReaction = () => {
        for (const reaction of reactionData) {
            for (const user of reaction.users) {
                // user found
                if (user.id === props.user.id) {
                    setUserReactions({
                        id: reaction.id,
                        image_url: reaction.image_url,
                        name: reaction.name
                    });
                    return;
                }
            }
        }
    }
    useLayoutEffect(() => {

        plugins.createPopup({
            triggerElement: reactionBoxTriggerRef.current,
            premadeContentElement: reactionBoxRef.current,
            type: 'premade',
            popupSelectors: ['reaction-box-popup', 'animate-slide-down']
        });

        if (props.user) {
            getUserReaction();
        }
    }, []);
    const activateFirstReactionBoxTab = () => {
        setReactionBoxActiveTab(0);
    };

    useEffect(() => {

        reactionBoxTriggerRef.current.addEventListener('mousedown', activateFirstReactionBoxTab);

        return () => {
            reactionBoxTriggerRef?.current?.removeEventListener('mousedown', activateFirstReactionBoxTab);
        };
    }, [props.index]);
    const numFormatter = (num) => {
        if (num < 1000) {
            return num;
        }

        if (num < 1000000) {
            return (num / 1000).toFixed(1) + 'K';
        }

        if (num >= 1000000 && num < 1000000000) {
            return (num / 1000000).toFixed(1) + 'M';
        }

        if (num >= 1000000000 && num < 1000000000000) {
            return (num / 1000000000).toFixed(1) + 'B';
        }

        return (num / 1000000000000).toFixed(1) + 'T';

    }
    const commentsText = props.commentCount === 1 ? cirkle_lng.comment : cirkle_lng.comments;
    let reactionCount = 0;

    return (
        <div className="post-body">
            <PostActivityPreview data={props.data}/>
            <div className="activity-inner">
                <p className="widget-box-status-text"
                   dangerouslySetInnerHTML={{__html: app.replaceEnterWithBr(app.wrapLinks(props.data.content))}}></p>

                {
                    'mpp_media_upload' === props.data.type && props.data.uploaded_media && (props.data.uploaded_media.data.length) &&
                    <ActivityMedia data={props.data}/>
                }
            </div>
            <div className="post-meta-wrap">
                <div ref={reactionBoxTriggerRef} className="post-meta activity-reaction post-reaction">
                    {

                        props.reactionData.length > 0 &&
                        props.reactionData.map(reaction => {
                            reactionCount = reactionCount + parseInt(reaction.reaction_count);
                            return <div className="reaction-icon" key={reaction.id}>
                                <img
                                    src={reaction.image_url}
                                    alt={reaction.name}
                                />
                            </div>
                        })
                    }
                    {
                        props.reactionData.length > 0 && <>
                            <div
                                className="meta-text reaction-count">{!reactionCount || userReaction && 1 === reactionCount ? '' : numFormatter(reactionCount)}</div>
                            <span className="">{userReaction ? 'You' : ''}</span></>
                    }
                    {
                        props.reactionData.length < 1 && <>{cirkle_lng.no_reactions}</>
                    }
                </div>
                <ReactionBox forwardedRef={reactionBoxRef}
                             data={props.reactionData}
                             reactionCount={reactionCount}
                             activeTab={reactionBoxActiveTab}
                             showTab={setReactionBoxActiveTab}
                />

                <div className="post-meta activity-meta">
                    <div className="meta-text">
                        <span>{numFormatter(props.commentCount)}</span> {commentsText}
                    </div>
                </div>
            </div>
        </div>
    );
}

export default PostBody;
