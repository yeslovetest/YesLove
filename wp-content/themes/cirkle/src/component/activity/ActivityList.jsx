import React from 'react';

import Activity from './Activity';

const ActivityList =(props)=> {
    const renderedActivities = props.data.map((activityData, i) => {
        let renderedActivity = [];

        renderedActivity.push(
            <Activity key={activityData.id}
                      data={activityData}
                      user={props.user}
                      profileUserID={props.profileUserID}
                      pinnedActivityID={props.pinnedActivityID}
                      pinActivity={props.pinActivity}
                      unpinActivity={props.unpinActivity}
                      updateActivity={props.updateActivity}
                      deleteActivity={props.deleteActivity}
                      reactions={props.reactions}
                      onShare={props.onShare}
                      onPlay={props.onPlay}
                      onActivityUpdate={props.onActivityUpdate}
                      activityIndex={i}
            />
        );
        return renderedActivity;
    });

    return (renderedActivities);
}

export default ActivityList;