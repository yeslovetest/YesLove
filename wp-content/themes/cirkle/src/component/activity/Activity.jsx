import React, {useState, useRef, useEffect} from 'react';

import router from '../../router/WP_Router';
import app from "../../helper/core";
import groupUtils from '../utils/group';
import ActivitySettings from './ActivitySettings';
import PostFooter from '../post/PostFooter';
import ActivityCommentList from '../comment/ActivityCommentList';
import PostHeader from "../post/PostHeader";
import PostBody from "../post/PostBody";
import {ActivityReactionable} from "../utils/reaction";

const Activity = (props) => {
    const [favorite, setFavorite] = useState(props.data.favorite);
    const [showMore, setShowMore] = useState(false);
    const [showingMore, setShowingMore] = useState(false);
    const [editingActivity, setEditingActivity] = useState(false);
    const [processingDelete, setProcessingDelete] = useState(false);
    const [processingFavorite, setProcessingFavorite] = useState(false);
    const [processingPinned, setProcessingPinned] = useState(false);
    const [isCfActive, setCfActive] = useState(false);
    const [commentCount, setCommentCount] = useState(props.data.comment_count);

    const activityReactionableProps = {
        entityData: {activity_id: props.data.id},
        user: props.user,
        reactions: props.reactions,
        reactionData: props.data.reactions,
        onUserReactionUpdate: (newReactionData) => {
            const newActivityData = app.deepMerge(props.data);
            newActivityData.reactions = newReactionData;
            props.onActivityUpdate(newActivityData);
        }
    };

    const activityReactionable = ActivityReactionable(activityReactionableProps);

    const showMoreSettingIsEnabled = cirkle_vars.activity_show_more_status === 'enabled';
    const widgetBoxStatusRef = useRef(null);

    const showMoreActivity = () => {
        setShowingMore(true);

        widgetBoxStatusRef.current.classList.remove('widget-box-status-limited');
        widgetBoxStatusRef.current.style.maxHeight = '100%';
    };

    const showLessActivity = () => {
        setShowingMore(false);

        widgetBoxStatusRef.current.classList.add('widget-box-status-limited');
        widgetBoxStatusRef.current.style.maxHeight = `${cirkle_vars.activity_show_more_height}px`;
    };

    const attachShowMoreElement = () => {
        setShowMore(true);

        showLessActivity();
    };

    useEffect(() => {
        if (showMoreSettingIsEnabled && widgetBoxStatusRef.current && widgetBoxStatusRef.current.offsetHeight > cirkle_vars.activity_show_more_height) {
            attachShowMoreElement();
        }
    }, []);


    const deleteActivity = () => {
        if (processingDelete) {
            return;
        }

        setProcessingDelete(true);

        // console.log('ACTIVITY - DELETE ACTIVITY ID: ', props.data.id, 'FROM USER: ', props.user.id);

        props.deleteActivity(props.data.id, (response) => {
            setProcessingDelete(false);
        });
    };

    const pinActivity = () => {
        if (processingPinned) {
            return;
        }

        setProcessingPinned(true);

        // console.log('ACTIVITY - PIN ACTIVITY ID: ', props.data.id, 'FROM USER: ', props.user.id);

        props.pinActivity(props.data.id, () => {
            setProcessingPinned(false);
        });
    };

    const unpinActivity = () => {
        if (processingPinned) {
            return;
        }

        setProcessingPinned(true);

        // console.log('ACTIVITY - UNPIN ACTIVITY ID: ', props.data.id, 'FROM USER: ', props.user.id);

        props.unpinActivity(() => {
            setProcessingPinned(false);
        });
    };

    const addFavorite = () => {
        if (processingFavorite) {
            return;
        }

        // console.log('ACTIVITY - ADD FAVORITE ACTIVITY ID: ', props.data.id, 'FROM USER: ', props.user.id);

        setProcessingFavorite(true);

        const config = {
            userID: props.user.id,
            activityID: props.data.id
        };

        router.addActivityFavorite(config, (response) => {
            // console.log('ACTIVITY - FAVORITE ADD RESPONSE: ', response);

            if (response) {
                setFavorite(true);
            }

            setProcessingFavorite(false);
        });
    };

    const removeFavorite = () => {
        if (processingFavorite) {
            return;
        }

        // console.log('ACTIVITY - REMOVE FAVORITE ACTIVITY ID: ', props.data.id, 'FROM USER: ', props.user.id);

        setProcessingFavorite(true);

        const config = {
            userID: props.user.id,
            activityID: props.data.id
        };

        router.removeActivityFavorite(config, (response) => {
            // console.log('ACTIVITY - FAVORITE REMOVE RESPONSE: ', response);

            if (response) {
                setFavorite(false);
            }

            setProcessingFavorite(false);
        });
    };

    const startEditingActivity = () => {
        setEditingActivity(true);
    };

    const stopEditingActivity = () => {
        setEditingActivity(false);
    };

    const updateActivity = (text) => {
        const activityContent = app.filterActivityContentForSave(text);

        const activityData = {
            id: props.data.id,
            component: props.data.component,
            type: props.data.type,
            user_id: props.data.author.id,
            content: activityContent,
            recorded_time: props.data.date,
            item_id: props.data.item_id,
            secondary_item_id: props.data.secondary_item_id,
            hidden: props.data.hide_sitewide === 1
        };

        props.updateActivity(activityData, stopEditingActivity);
    };

    const updateCfActive = (state) => {
        if (typeof state === 'undefined') {
            setCfActive(prev => !prev);
        } else {
            setCfActive(state);
        }
    }

    const updateCommentCount = (value) => {
        setCommentCount(previousCommentCount => {
            return previousCommentCount + value;
        });
    }

    const updateReactionData = (reactionsData) => {
        // this.setState({reactionsData: reactionsData})
    }

    const isActivityAuthor = props.user && (props.data.author.id === props.user.id);

    // let userCanUseSettings = props.user,
    let userCanUseSettings = true,
        userCanDeleteActivity = isActivityAuthor;

    const isGroupActivity = props.data.component === 'groups';

    // if this activity belongs to a group
    if (props.user && isGroupActivity) {
        const groupable = groupUtils(props.user, props.data.group);

        userCanUseSettings = !groupable.isBannedFromGroup();
        userCanDeleteActivity = groupable.isGroupAdmin() || groupable.isGroupMod() || (isActivityAuthor && groupable.isGroupMember());
    }
    const activityIsPinned = props.pinnedActivityID && (props.pinnedActivityID === props.data.id);

    return (
        <div className={`activity-item type-${props.data.type}`} id={`activity-${props.data.id}`}>
            <div className="block-box post-view">
                {/* TAG STICKERS */}
                <div className="tag-stickers">
                    {
                        favorite && <i className="icofont-ui-love"/>
                    }
                    {
                        (props.data.hide_sitewide === 1) && <i className="icofont-lock"/>
                    }
                    {
                        activityIsPinned && <i className="icofont-tack-pin"/>
                    }
                </div>
                {/* TAG STICKERS */}

                {
                    props.user && userCanUseSettings &&
                    <ActivitySettings userIsActivityAuthor={isActivityAuthor}
                                      userCanDeleteActivity={userCanDeleteActivity}
                                      favorite={favorite}
                                      pinned={activityIsPinned}
                                      addFavorite={addFavorite}
                                      removeFavorite={removeFavorite}
                                      processingFavorite={processingFavorite}
                                      pinActivity={pinActivity}
                                      unpinActivity={unpinActivity}
                                      processingPinned={processingPinned}
                                      startEditingActivity={startEditingActivity}
                                      deleteActivity={deleteActivity}
                                      processingDelete={processingDelete}
                    />
                }
                <PostHeader data={props.data}
                            user={props.user}/>

                <PostBody data={props.data}
                          commentCount={commentCount}
                          user={props.user}
                          reactionData={props.data.reactions}/>

                <PostFooter commentCount={commentCount}
                            shareType='activity'
                            shareData={props.data}
                            shareCount={Number.parseInt(props.data.meta.share_count, 10) || 0}
                            onShare={props.onShare}
                            user={props.user}
                            reactions={props.reactions}
                            reactionData={props.data.reactions}
                            updateCfActive={updateCfActive}
                            userReaction={activityReactionable.getUserReaction()}
                            createUserReaction={activityReactionable.createUserReaction}
                            deleteUserReaction={activityReactionable.deleteUserReaction}
                            postType='activity'
                            onPlay={props.onPlay}
                />
                <ActivityCommentList activityID={props.data.id}
                                     parentData={props.data}
                                     comments={props.data.comments}
                                     isCfActive={isCfActive}
                                     updateCommentCount={updateCommentCount}
                                     updateCfActive={updateCfActive}
                                     user={props.user}
                                     reactions={props.reactions}
                                     perPage={2}
                                     order='DESC'
                                     formPosition='top'
                />

            </div>
        </div>
    );
}

export default Activity;
