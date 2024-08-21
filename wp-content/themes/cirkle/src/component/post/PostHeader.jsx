import Avatar from "../avatar/Avatar";
import BadgeVerified from "../badge/BadgeVerified";

const PostHeader = (props) => {
    const displayVerifiedMemberBadge = cirkle_vars.plugin_active['bp-verified-member'] && cirkle_vars.bp_verified_member_display_badge_in_activity_stream && props.data.author.verified;
    return (
        <div className="post-header">
            <div className="media">
                <div className="activity-avatar">
                    <div className="user-img">
                        <Avatar size="small" noBorder data={props.data.author}/>
                    </div>
                    <div className="status-info">
                        <div className="activity-title">
                            <a href={props.data.author.link}>{props.data.author.name}</a>
                            {
                                displayVerifiedMemberBadge &&
                                <BadgeVerified/>
                            }
                            <span dangerouslySetInnerHTML={{__html: ` ${props.data.action}`}}></span>
                        </div>
                        <div className="activity-time">{props.data.timestamp}</div>
                    </div>
                </div>
            </div>
        </div>
    );
}
export default PostHeader;
