import React from 'react';

import Avatar from '../avatar/Avatar';
import BadgeVerified from "../badge/BadgeVerified";

const UserStatus = (props) => {
    const displayVerifiedMemberBadge = cirkle_vars.plugin_active['bp-verified-member'] && props.showVerifiedBadge && props.data.verified;
    return (
        <div className="user-status request-small">
            <Avatar size="small" modifiers='user-status-avatar' noBorder data={props.data}/>

            <p className="user-status-title">
                <a className="bold" href={props.data.link}>{props.data.name}</a>
                {
                    displayVerifiedMemberBadge && cirkle_vars.bp_verified_member_display_badge_in_profile_fullname &&
                    <BadgeVerified/>
                }
            </p>
            <p className="user-status-text small">&#64;{props.data.mention_name}
                {
                    displayVerifiedMemberBadge && cirkle_vars.bp_verified_member_display_badge_in_profile_username &&
                    <BadgeVerified/>
                }
            </p>

            <div className="action-request-list">
                <img className="user-status-reaction-image" src={props.data.reaction.image_url}
                     alt={`reaction-${props.data.reaction.name}`}/>
            </div>
        </div>
    );
}

export default UserStatus;