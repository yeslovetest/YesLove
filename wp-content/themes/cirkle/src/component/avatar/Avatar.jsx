import React from 'react';

const Avatar = (props) => {

    const Element = props.noLink || !cirkle_vars.plugin_active.buddypress ? 'div' : 'a';

    return (
        <Element
            className={`user-avatar${props.size ? ' ' + props.size : ''} ${props.noBorder ? 'no-outline' : ''} ${props.modifiers || ''}`}
            {...(!props.noLink ? {href: props.data?.link} : {})}
        >
            <img alt="" className="avatar user-2-avatar photo" src={props.data?.avatar_url}/>
        </Element>
    );
}

export default Avatar;