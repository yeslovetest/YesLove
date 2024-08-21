import React, {useState} from 'react';
import PostReactionOption from '../post/PostReactionOption';

const PostFooter =(props)=>{

    return (
        <div className="post-footer">
            {
                !props.disableActions && props.user &&
                <ul className="post-options">
                    {
                        (['post', 'activity'].includes(props.postType) && cirkle_vars.plugin_active.rtreact) &&
                        <PostReactionOption reactions={props.reactions}
                                            userReaction={props.userReaction}
                                            createUserReaction={props.createUserReaction}
                                            deleteUserReaction={props.deleteUserReaction}
                                            simpleOptions={props.simpleOptions}
                        />
                    }

                    {/* POST OPTION */}
                    <li className="post-option post-comment-option">
                        <div className="post-action" onClick={(e) => {
                            e.preventDefault();
                            props.updateCfActive();
                        }}>
                            <i className="icofont-comment"></i>
                            <span className="post-option-text">{cirkle_lng.comment_action}</span>
                        </div>
                    </li>
                </ul>
            }
        </div>
    );
}

export default PostFooter;
