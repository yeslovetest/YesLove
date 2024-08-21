import Avatar from "../avatar/Avatar";
import React from "react";

const PostActivityPreview = (props) => {
    let link, image_url, name, item, slug;
    if (!['created_group', 'joined_group', 'friendship_created'].includes(props.data.type)) {
        return <></>;
    }
    if (props.data.type === 'created_group' || props.data.type === 'joined_group') {
        link = props.data.group.link;
        image_url = props.data.group.cover_image_url;
        item = props.data.group;
        name = props.data.group.name;
        slug = props.data.group.slug;
    } else {
        link = props.data.friend?.link || "";
        image_url = props.data.friend?.cover_url || '';
        item = props.data.friend;
        name = props.data.friend?.name || "";
        slug = props.data.friend?.mention_name || "";
    }
    return (
        <div className="post-friends-view">
            <div className="profile-thumb">
                <div className="cover-img">
                    <a href={link}>
                        <img src={image_url} alt={name}/>
                    </a>
                </div>
                <div className="media">
                    <div className="profile-img">
                        <Avatar modifiers='preview--avatar' data={item}/>
                    </div>
                    <div className="media-body">
                        <div className="profile-name"><a
                            href={link}>{name}</a></div>
                        <div className="user-name"><a
                            href={link}>&#64;{slug}</a></div>
                    </div>
                </div>
            </div>
        </div>
    )
}


export default PostActivityPreview;
