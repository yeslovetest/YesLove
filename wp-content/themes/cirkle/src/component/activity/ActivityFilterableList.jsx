import React, {useState, useRef, useEffect} from 'react';

import app from '../../helper/core';

import router from '../../router/WP_Router';

import ActivityFilterBar from './ActivityFilterBar';
import ActivityList from './ActivityList';
import Notification from '../notification/Notification';
import Loader from '../loader/Loader';

import Paginator from '../../helper/Paginator';

import ScrollPager from '../pager/ScrollPager';

const ActivityFilterableList = (props) => {
    const [activities, setActivities] = useState({
        items: [],
        initialFetch: true,
        moreItems: true
    });
    const [pinnedActivityID, setPinnedActivityID] = useState(false);

    const [reactions, setReactions] = useState([]);

    const [fetchingUser, setFetchingUser] = useState(false);
    const [loggedUser, setLoggedUser] = useState(false);

    const currentPage = useRef(1);

    const createCount = useRef(0);
    const deleteCount = useRef(0);

    const preloadedActivities = useRef(null);

    const filters = useRef({
        per_page: props.perPage,
        sort: props.order,
        show_hidden: !!props.groupID,
        scope: false,
        filter: {}
    });

    const onBpActivityUpdate = () => {
        if (false === filters.current.scope) {
            onFiltersChange(filters.current);
            return;
        }

        const newFilters = {
            ...filters.current,
            scope: false
        };
        onFiltersChange(newFilters);
    }

    useEffect(() => {
        if (props.activityID && !props.groupID) {
            filters.current.in = props.activityID;
        }

        if (!props.noFilter) {
            filters.current.filter.object = [
                'activity',
                'profile',
                'gamipress'
            ];

            filters.current.filter.action = [
                'activity_update',
                'activity_share',
                'post_share',
                'new_avatar',
                'new_member'
            ];

            if (cirkle_vars.plugin_active.buddypress_groups) {
                filters.current.filter.object.push('groups');
                filters.current.filter.action.push('created_group', 'joined_group');
            }

            if (cirkle_vars.plugin_active.buddypress_friends) {
                filters.current.filter.object.push('friends');
                filters.current.filter.action.push('friendship_created');
            }

            if (cirkle_vars.plugin_active.mediapress) {
                filters.current.filter.action.push('mpp_media_upload');
            }

            if (cirkle_vars.plugin_active.bbpress) {
                filters.current.filter.object.push('bbpress');
                filters.current.filter.action.push('bbp_topic_create', 'bbp_reply_create');
            }
        }

        document.addEventListener('cirkle_bp_activity_updated', onBpActivityUpdate);

        return () => {
            document.removeEventListener('cirkle_bp_activity_updated', onBpActivityUpdate)
        }
    }, []);

    const onFiltersChange = (newFilters) => {
        // console.log('ACTIVITY FILTERABLE LIST - ON FILTERS CHANGE: ', newFilters);

        app.deepExtend(filters.current, newFilters);

        if (typeof filters.current.filter.action === 'undefined') {
            filters.current.filter.action = [
                'activity_update',
                'activity_share',
                'post_share',
                'new_avatar',
                'new_member'
            ];

            if (cirkle_vars.plugin_active.buddypress_groups) {
                filters.current.filter.action.push('created_group', 'joined_group');
            }

            if (cirkle_vars.plugin_active.buddypress_friends) {
                filters.current.filter.action.push('friendship_created');
            }

            if (cirkle_vars.plugin_active.mediapress) {
                filters.current.filter.action.push('mpp_media_upload');
            }

            if (cirkle_vars.plugin_active.bbpress) {
                filters.current.filter.action.push('bbp_topic_create', 'bbp_reply_create');
            }
        }

        filters.current.filter.object = [
            'activity',
            'profile',
            'gamipress'
        ];

        if (cirkle_vars.plugin_active.buddypress_groups) {
            filters.current.filter.object.push('groups');
        }

        if (cirkle_vars.plugin_active.buddypress_friends) {
            filters.current.filter.object.push('friends');
        }

        if (cirkle_vars.plugin_active.bbpress) {
            filters.current.filter.object.push('bbpress');
        }

        reloadActivities();
    };

    const getActivities = (callback, options = {}) => {
        // get next page to fetch based on create and delete counts
        currentPage.current = Paginator.getNextPageToFetch({
            page: currentPage.current,
            per_page: props.perPage,
            createCount: createCount.current,
            deleteCount: deleteCount.current
        });

        // reset counts
        createCount.current = 0;
        deleteCount.current = 0;

        const config = {
            page: currentPage.current
        };

        app.deepExtend(config, filters.current);
        app.deepExtend(config, options);

        // get activities of this user only
        if (props.userID) {
            config.filter.user_id = props.userID;

            if (currentPage.current === 1) {
                config.include_pinned_from = props.userID;
            }
        }

        // get activities of this group only
        if (props.groupID) {
            config.filter.primary_id = props.groupID;
            config.filter.object = 'groups';
        }

        // console.log('ACTIVITY FILTERABLE LIST - ACTIVITY FILTERS: ', config);
        router.getActivities(config, callback);
    };

    const reloadActivities = () => {
        currentPage.current = 1;

        // reset counts
        createCount.current = 0;
        deleteCount.current = 0;

        setActivities({
            items: [],
            initialFetch: true,
            moreItems: true
        });

        getActivitiesPage();
    };

    const preloadActivities = (options, scope) => {
        const preloadedActivities = jQuery.Deferred();

        getActivities((response) => {
            // console.log('ACTIVITY FILTERABLE LIST - PRELOADED ACTIVITY DATA: ', response);

            // cancel if scope changed
            const newScope = filters.current.scope;

            if (newScope !== scope) {
                preloadedActivities.resolve([], false);
                return;
            }

            currentPage.current += 1;

            const activitiesWithoutDuplicates = Paginator.removeDuplicates(activities.items, response.activities, 'id');

            preloadedActivities.resolve(activitiesWithoutDuplicates, response.has_more_items);
        }, options);

        return preloadedActivities.promise();
    };

    const getActivitiesPage = (callback = () => {
    }) => {
        const scope = filters.current.scope;

        // exclude pinned activity if exists
        const options = pinnedActivityID ? {exclude: pinnedActivityID} : {};

        if (currentPage.current === 1) {
            getActivities((response) => {
                // console.log('ACTIVITY FILTERABLE LIST - ACTIVITY DATA: ', response);

                // cancel if scope changed
                const newScope = filters.current.scope;

                if (newScope !== scope) {
                    callback(false);
                    return;
                }

                currentPage.current += 1;

                if ((response.activities.length > 0) && response.activities[0].pinned) {
                    setPinnedActivityID(response.activities[0].id);
                    // exclude pinned activity for next preload
                    options.exclude = response.activities[0].id;
                }

                setActivities(previousActivities => {
                    const activitiesWithoutDuplicates = Paginator.removeDuplicates(previousActivities.items, response.activities, 'id');

                    return {
                        items: previousActivities.items.concat(activitiesWithoutDuplicates),
                        moreItems: response.has_more_items,
                        initialFetch: false
                    };
                });

                callback(response.has_more_items);

                // preload next page activities
                preloadedActivities.current = preloadActivities(options, filters.current.scope);
            }, options);
        } else {
            // dump preloaded activities and preload next page if has more items
            preloadedActivities.current
                .done((activities, hasMoreItems) => {
                    // console.log('ACTIVITY FILTERABLE LIST - PRELOADED ACTIVITY DATA: ', activities);

                    setActivities(previousActivities => {
                        return {
                            ...previousActivities,
                            items: previousActivities.items.concat(activities),
                            moreItems: hasMoreItems
                        };
                    });

                    callback(hasMoreItems);

                    // preload next page if has more items
                    if (hasMoreItems) {
                        // preload next page activities
                        preloadedActivities.current = preloadActivities(options, filters.current.scope);
                    }
                });
        }
    };

    const createActivity = (data, callback) => {
        // console.log('ACTIVITY FILTERABLE LIST - CREATE ACTIVITY WITH DATA: ', data);

        const itemID = Number.parseInt(data.postIn, 10);

        // post public by default
        let hideSitewide = false;

        // if posting to a group, get group privacy to set hideSitewide
        if (itemID !== 0) {
            for (const group of loggedUser.groups) {
                // user is a member of the group
                if (group.id === itemID) {
                    // hide sitewide if not public group
                    hideSitewide = group.status !== 'public';
                    break;
                }
            }
        }

        let uploadable_media = false;

        if (data.uploadable_media) {
            const component = itemID === 0 ? 'member' : 'group',
                componentID = component === 'member' ? loggedUser.id : itemID,
                files = [];

            for (const media of data.uploadable_media) {
                files.push(media.file);
            }

            uploadable_media = {
                files: files,
                component: {
                    type: component,
                    id: componentID,
                    uploader_id: loggedUser.id
                }
            };
        }

        let activityType = 'activity_update';

        if (uploadable_media) {
            if (data.uploadable_media_type === 'image') {
                activityType = 'activity_media_update';
            } else if (data.uploadable_media_type === 'video') {
                activityType = 'activity_video_update';
            }
        }

        const activityContent = filterActivityContentForSave(data.text);

        const activityData = {
            creation_config: {
                item_id: itemID,
                user_id: loggedUser.id,
                component: itemID === 0 ? 'activity' : 'groups',
                type: activityType,
                content: activityContent,
                hide_sitewide: hideSitewide
            },
            attached_media: data.attached_media,
            uploadable_media: uploadable_media,
            uploadable_media_type: data.uploadable_media_type
        };

        // console.log('ACTIVITY FILTERABLE LIST - CREATE ACTIVITY: ', activityData);

        router.createActivity(activityData, (response) => {
            // console.log('ACTIVITY FILTERABLE LIST - CREATE ACTIVITY RESPONSE: ', response);

            // activity created
            if (response) {
                onCreatedActivity(response, itemID, callback);
            } else {
                callback(response);
            }
        });
    };

    const onCreatedActivity = (activityID, itemID, callback) => {
        createCount.current += 1;

        const postedInMyProfile = loggedUser.id === props.userID,
            postedInMyGroup = itemID === props.groupID,
            postedInNewsfeed = !props.userID;

        // if activity created and logged user is viewing newsfeed, it's own profile or the group where he is posting
        // get created activity for display
        if (postedInNewsfeed || postedInMyProfile || postedInMyGroup) {
            // get created activity using current filters, if the created activity returns then prepend it
            // otherwise it shouldn't be displayed with current filters
            const getCreatedActivityFilters = app.deepMerge(filters.current);
            // limit to created activity id
            getCreatedActivityFilters.in = activityID;

            router.getActivities(getCreatedActivityFilters, (createdActivityResponse) => {
                // console.log('ACTIVITY FILTERABLE LIST - CREATED ACTIVITY GET: ', createdActivityResponse);

                if (createdActivityResponse.activities.length) {
                    const createdActivity = createdActivityResponse.activities[0];

                    // add activity to state activities
                    setActivities(previousActivities => {
                        const newActivities = previousActivities.items.slice();

                        newActivities.unshift(createdActivity);

                        return {
                            ...previousActivities,
                            items: newActivities
                        };
                    });
                }

                callback(activityID);
            });
        }
    };


    const updateActivity = (data, callback) => {
        // console.log('ACTIVITY FILTERABLE LIST - UPDATE ACTIVITY - DATA: ', data);

        const activityUpdatePromise = router.updateActivity(data);

        activityUpdatePromise
            .done((response) => {
                // console.log('ACTIVITY FILTERABLE LIST - UPDATE ACTIVITY - RESPONSE: ', response);

                // activity updated successfully
                if (response) {
                    // fetch the updated activity
                    const getUpdatedActivityFilters = {
                        in: data.id
                    };

                    router.getActivities(getUpdatedActivityFilters, (updatedActivityResponse) => {
                        // console.log('ACTIVITY FILTERABLE LIST - UPDATED ACTIVITY GET: ', updatedActivityResponse);

                        if (updatedActivityResponse.activities.length) {
                            const updatedActivity = updatedActivityResponse.activities[0];

                            onActivityUpdate(updatedActivity);
                        }

                        callback();
                    });
                }
            })
            .fail((error) => {
                // console.log('ACTIVITY FILTERABLE LIST - UPDATE ACTIVITY - ERROR: ', error);
            });
    };


    const deleteActivity = (activity_id, callback) => {
        // console.log('ACTIVITY FILTERABLE LIST - DELETE ACTIVITY: ', activity_id);

        router.deleteActivity(activity_id, (response) => {
            // console.log('ACTIVITY FILTERABLE LIST - DELETE ACTIVITY RESPONSE: ', response);

            callback(response);

            // activity deleted
            if (response) {
                deleteCount.current += 1;

                // remove from state activities
                setActivities(previousActivities => {
                    const newActivities = previousActivities.items.filter((activity) => {
                        return activity.id !== activity_id;
                    });

                    return {
                        ...previousActivities,
                        items: newActivities
                    };
                });
            }
        });
    };
    const pinActivity = (activityID, callback) => {
        // console.log('ACTIVITY FILTERABLE LIST - PIN ACTIVITY ID: ', activityID, 'FROM USER: ', loggedUser.id);

        const config = {
            userID: loggedUser.id,
            activityID: activityID
        };

        router.pinActivity(config, (response) => {
            // console.log('ACTIVITY FILTERABLE LIST - PIN RESPONSE: ', response);

            if (response) {
                setPinnedActivityID(activityID);
            }

            callback();
        });
    };

    const unpinActivity = (callback) => {
        // console.log('ACTIVITY FILTERABLE LIST - UNPIN ACTIVITY FROM USER: ', loggedUser.id);

        const config = {
            userID: loggedUser.id
        };

        router.unpinActivity(config, (response) => {
            // console.log('ACTIVITY FILTERABLE LIST - UNPIN RESPONSE: ', response);

            if (response) {
                setPinnedActivityID(false);
            }

            callback();
        });
    };
    const getLoggedUser = () => {
        setFetchingUser(true);

        router.getLoggedInMember('user-activity')
            .done((loggedUser) => {
                // console.log('ACTIVITY FILTERABLE LIST - LOGGED IN USER: ', loggedUser);

                setLoggedUser(loggedUser);
                setFetchingUser(false);
            });
    };

    const getReactions = () => {
        if (cirkle_vars.plugin_active.rtreact) {
            router.getReactions()
                .done((response) => {
                    setReactions(response);
                });
        }
    };

    const onActivityUpdate = (newActivityData) => {
        // console.log('ACTIVITY FILTERABLE LIST - ON ACTIVITY UPDATE - NEW ACTIVITY DATA: ', newActivityData);

        setActivities(previousActivities => {
            return {
                ...previousActivities,
                items: app.updateActivities(previousActivities.items, newActivityData)
            };
        });
    };

    useEffect(() => {
        getLoggedUser();

        getReactions();

        getActivitiesPage();
    }, []);

    let postInDefault = '0';

    // if user is logged in and viewing a group activity feed
    if (loggedUser && props.groupID) {
        // check if the user is a member of the group and set the default post option to that group
        for (const group of loggedUser.groups) {
            // user is a member of the group
            if (group.id === props.groupID) {
                postInDefault = group.id + '';
                break;
            }
        }
    }

    return (
        <>
            {
                fetchingUser &&
                <Loader/>
            }
            {
                !fetchingUser &&
                <>
                    {
                        !props.activityID &&
                        <ActivityFilterBar onFiltersChange={onFiltersChange}
                                           hideGroupsFilter={Boolean(props.groupID)}
                        />
                    }

                    <ScrollPager modifiers="activity-list item-list" loadMoreItems={getActivitiesPage}
                                 moreItems={activities.moreItems} initialFetch={activities.initialFetch}>
                        {
                            (activities.items.length === 0) && !activities.moreItems &&
                            <Notification title={cirkle_lng.activity_no_results_title}
                                          text={cirkle_lng.activity_no_results_text}
                            />
                        }
                        {
                            (activities.items.length > 0) &&
                            <ActivityList data={activities.items}
                                          user={loggedUser}
                                          reactions={reactions}
                                          profileUserID={props.userID}
                                          pinnedActivityID={pinnedActivityID}
                                          pinActivity={pinActivity}
                                          unpinActivity={unpinActivity}
                                          updateActivity={updateActivity}
                                          deleteActivity={deleteActivity}
                                          onShare={onCreatedActivity}
                                          onActivityUpdate={onActivityUpdate}
                            />
                        }
                    </ScrollPager>
                </>
            }
        </>
    );
}

export default ActivityFilterableList;
