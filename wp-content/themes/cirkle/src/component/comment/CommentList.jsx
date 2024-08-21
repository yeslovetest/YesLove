import React, {useState} from 'react';

import Comment from './Comment';
import Reactionable from '../reaction/Reactionable';

const CommentList = (props) => {

    const [deleting, setDeleting] = useState(false);

    const deleteComment = (config) => {
        setDeleting(config.comment_id);

        props.deleteComment(config, (response) => {
            // console.log('COMMENT LIST - DELETE COMMENT RESPONSE: ', response);

            if (!response) {
                setDeleting(false);
            }
        });
    };

    const onReplyButtonClick = (commentID) => {
        props.getChildrenComments(commentID);
        props.onReplyButtonClick(commentID);
    };
    const depth = props.depth || 1;
    const replyText = depth === 2 && props.childrenComments > 1 ? cirkle_lng.replies : cirkle_lng.reply,
        commentsLeft = props.commentCount - props.comments.length,
        hasMoreComments = commentsLeft > 0;
    const renderedComments = [];
    for (let i = 0; i < props.comments.length; i++) {
        const comment = props.comments[i];
        renderedComments.push(
            <div className="post-comment-list" key={comment.id}>
                <Reactionable entityData={props.entityData(comment.id)}
                              user={props.user}
                              reactions={props.reactions}
                              reactionData={comment.reactions}
                              createUserReaction={props.createUserReaction}
                              deleteUserReaction={props.deleteUserReaction}
                >
                    {
                        (reactionData, userReaction, createUserReaction, deleteUserReaction) => {
                            return (
                                <Comment data={comment}
                                         user={props.user}
                                         allowGuest={props.allowGuest}
                                         onReplyButtonClick={() => {
                                             depth === 1 && comment.hasChildren ? onReplyButtonClick(comment.id) : props.onReplyButtonClick(comment.id);
                                         }}
                                         onCancelReplyButtonClick={props.onCancelReplyButtonClick}
                                         onDeleteButtonClick={props.onDeleteButtonClick}
                                         createComment={props.createComment}
                                         updateComment={props.updateComment}
                                         deleteComment={deleteComment}
                                         depth={depth}
                                         reactions={props.reactions}
                                         reactionData={reactionData}
                                         userReaction={userReaction}
                                         createUserReaction={createUserReaction}
                                         deleteUserReaction={deleteUserReaction}
                                         postType={props.postType}
                                         showVerifiedBadge={props.showVerifiedBadge}
                                />
                            );
                        }
                    }
                </Reactionable>
                {
                    comment.children instanceof Array &&
                    <CommentList comments={comment.children}
                                 user={props.user}
                                 createComment={props.createComment}
                                 updateComment={props.updateComment}
                                 deleteComment={deleteComment}
                                 onReplyButtonClick={props.onReplyButtonClick}
                                 onCancelReplyButtonClick={props.onCancelReplyButtonClick}
                                 childrenComments={comment.hasChildren}
                                 getChildrenComments={() => {
                                     props.getChildrenComments(comment.id);
                                 }}
                                 commentCount={comment.children.length}
                                 depth={depth + 1}
                                 entityData={props.entityData}
                                 reactions={props.reactions}
                                 createUserReaction={props.createUserReaction}
                                 deleteUserReaction={props.deleteUserReaction}
                                 postType={props.postType}
                    />
                }
            </div>
        );
    }

    return (
        <div className="post-comment-list-wrap">
            {renderedComments}
            {
                (depth === 1) && hasMoreComments &&
                <p className="post-comment-heading animate-slide-down"
                   onClick={props.getMoreComments}>{cirkle_lng.load_more_comments} <span
                    className="highlighted">{commentsLeft}</span></p>
            }
            {
                (depth === 2) && props.childrenComments > 0 &&
                <p className={`post-comment-heading animate-slide-down reply-${depth}`}
                   onClick={props.getChildrenComments}>{cirkle_lng.load} <span
                    className="highlighted">{props.childrenComments}</span> {replyText}...</p>
            }
        </div>
    );
}

export default CommentList;