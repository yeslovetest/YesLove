import React, {useRef} from "react";

import app from "../../helper/core";
import {reorderComments} from "../utils/comment/comment-data";

import WP_Router from "../../router/WP_Router";

import AsyncCommentList from "./AsyncCommentList";

const ActivityCommentList = (props) => {
    const order = props.order ? props.order : "DESC";
    const comments = useRef(reorderComments(props.comments.slice(), order));

    const createComment = (commentData, callback) => {
        const config = {
            activityID: props.activityID,
        };

        app.deepExtend(config, commentData);
        WP_Router.createActivityComment(config, (response) => {
            if (response) {
                props.updateCommentCount(1);
            }
            callback(response);
        });
    };

    const getCommentCount = (callback) => {
        callback(comments.current.length);
    };

    const getComment = (commentID, callback) => {
        const config = {
            display_comments: "stream",
            in: commentID,
            filter: {
                action: "activity_comment",
            },
        };

        WP_Router.getActivities(config, (response) => {
            const comment =
                response.activities.length > 0 ? response.activities[0] : {};

            callback(comment);
        });
    };

    const getComments = (callback, options) => {
        const startPosition = (options.page - 1) * props.perPage,
            endPosition = startPosition + props.perPage,
            newComments = comments.current.slice(startPosition, endPosition);

        callback(newComments);
    };

    const updateComment = (commentData) => {
        const config = {
            id: commentData.id,
            component: commentData.component || "activity",
            type: commentData.type || "activity_comment",
            user_id: commentData.author.id,
            content: commentData.content,
            recorded_time: commentData.date,
            item_id: commentData.item_id || props.activityID,
            secondary_item_id: commentData.secondary_item_id || commentData.parent,
        };
        return WP_Router.updateActivity(config);
    };

    const deleteComment = (config) => {
        return WP_Router.deleteActivityComment({
            activity_id: props.activityID,
            comment_id: config.comment_id,
        });
    };

    return (
        <AsyncCommentList
            getComment={getComment}
            getComments={getComments}
            getCommentCount={getCommentCount}
            commentCount={comments.current.length}
            createComment={createComment}
            updateComment={updateComment}
            deleteComment={deleteComment}
            isCfActive={props.isCfActive}
            updateCfActive={props.updateCfActive}
            user={props.user}
            order={order}
            replyType={props.replyType}
            formPosition={props.formPosition}
            entityData={(id) => ({activity_id: id})}
            parentData={props.parentData}
            reactions={props.reactions}
            createUserReaction={WP_Router.createActivityUserReaction}
            deleteUserReaction={WP_Router.deleteActivityUserReaction}
            postType="activity"
            showVerifiedBadge={
                cirkle_vars.plugin_active["bp-verified-member"] &&
                cirkle_vars.bp_verified_member_display_badge_in_activity_stream
            }
        />
    );
};

export default ActivityCommentList;
