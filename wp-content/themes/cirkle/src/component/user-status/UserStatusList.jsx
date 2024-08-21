import React from 'react';

import UserStatus from './UserStatus';

const UserStatusList = (props) => {
    const renderedUserStatusList = props.data.map((user) => {
        return (
            <UserStatus key={user.id}
                        data={user}
                        showVerifiedBadge={props.showVerifiedBadge}
            />
        );
    });

    return (
        <div className="user-status-list">
            {renderedUserStatusList}
        </div>
    );
}

export default UserStatusList;