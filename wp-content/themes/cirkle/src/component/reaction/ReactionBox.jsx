import React from 'react';

import app from '../../helper/core';

import UserStatusList from '../user-status/UserStatusList';

const ReactionBox = (props) => {
    const activeTabSelector = 'active';
    let allReactionUsers = [];
    for (const reaction of props.data) {
        const users = [];

        for (const user of reaction.users) {
            const userReaction = {};
            app.deepExtend(userReaction, user);
            userReaction.reaction = {};
            userReaction.reaction.id = reaction.id;
            userReaction.reaction.name = reaction.name;
            userReaction.reaction.image_url = reaction.image_url;

            users.push(userReaction);
        }

        allReactionUsers = allReactionUsers.concat(users);
    }

    const reactions = [];

    for (const reaction of props.data.slice().reverse()) {
        const users = [];

        for (const user of reaction.users) {
            const userReaction = {};
            app.deepExtend(userReaction, user);
            userReaction.reaction = {};
            userReaction.reaction.id = reaction.id;
            userReaction.reaction.name = reaction.name;
            userReaction.reaction.image_url = reaction.image_url;

            users.push(userReaction);
        }

        reaction.users = users;
        reactions.push(reaction);
    }
    return (
        <div ref={props.forwardedRef} className="reaction-box">
            <div className="reaction-box-options">
                <div className={`reaction-box-option ${(props.activeTab === 0) && activeTabSelector}`}
                     onClick={(e) => {
                         props.showTab(0);
                     }}>
                    <p className="reaction-box-option-text">{`${cirkle_lng.all}: ${props.reactionCount}`}</p>
                </div>

                {
                    reactions.map((reaction, i) => {
                        return (
                            <div key={reaction.id}
                                 className={`reaction-box-option ${(props.activeTab === (i + 1)) && activeTabSelector}`}
                                 onClick={() => {
                                     props.showTab(i + 1);
                                 }}>
                                <img className="reaction-box-option-image" src={reaction.image_url}
                                     alt={`reaction-${reaction.name}`}/>
                                <p className="reaction-box-option-text">{reaction.reaction_count}</p>
                            </div>
                        );
                    })
                }
            </div>

            <div className="reaction-box-content">
                {
                    props.activeTab === 0 &&
                    <div className="reaction-box-item">
                        <UserStatusList data={allReactionUsers}
                                        showVerifiedBadge={cirkle_vars.bp_verified_member_display_badge_in_members_lists}
                        />
                    </div>
                }
                {
                    reactions.map((reaction, i) => {
                        return (
                            (props.activeTab === (i + 1)) &&
                            <div key={reaction.id} className="reaction-box-item">
                                <UserStatusList data={reaction.users}
                                                showVerifiedBadge={cirkle_vars.bp_verified_member_display_badge_in_members_lists}
                                />
                            </div>
                        );
                    })
                }
            </div>
        </div>
    );
}

export default ReactionBox;