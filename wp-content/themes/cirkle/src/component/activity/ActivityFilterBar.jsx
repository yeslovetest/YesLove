import React, {useState, useRef, useEffect} from 'react';

const ActivityFilterBar = (props) => {
    const [action, setAction] = useState('all');
    const [filters, setFilters] = useState({
        scope: false,
        filter: {}
    });

    const mounting = useRef(true);

    useEffect(() => {
        if (!mounting.current) {
            props.onFiltersChange(filters);
        } else {
            mounting.current = false;
        }
    }, [filters]);

    const setScopeAll = () => {
        changeScope(false);
    };
    const setScopeMentions = () => {
        changeScope('mentions');
    };
    const setScopeFavorites = () => {
        changeScope('favorites');
    };
    const setScopeFriends = () => {
        changeScope('friends');
    };
    const setScopeGroups = () => {
        changeScope('groups');
    };

    const changeScope = (newScope) => {
        // if scope didn't change, return
        if (newScope === filters.scope) {
            return;
        }

        const newFilters = {
            ...filters,
            scope: newScope
        };

        setFilters(newFilters);
    };

    const handleScopeChange = (e) => {
        const value = e.target.value === 'false' ? false : e.target.value;

        changeScope(value);
    };

    const handleActionChange = (e) => {
        const actionValue = e.target.value,
            filter = actionValue === 'all' ? {} : {action: actionValue};

        setAction(actionValue);

        setFilters({
            ...filters,
            filter: filter
        });
    };

    return (
        <div className="quick-filters item-list-tabs block-box user-timeline-header">
            <ul className="quick-filters-tabs menu-list d-md-block">
                <li className={!filters.scope ? 'current' : ''}>
                    <a onClick={(e) => {
                        e.preventDefault();
                        setScopeAll();
                    }}>{cirkle_lng.all_updates}</a>
                </li>
                <li className={filters.scope === 'mentions' ? 'current' : ''}>
                    <a onClick={(e) => {
                        e.preventDefault();
                        setScopeMentions();
                    }}>{cirkle_lng.mentions}</a>
                </li>
                <li className={filters.scope === 'favorites' ? 'current' : ''}>
                    <a onClick={(e) => {
                        e.preventDefault();
                        setScopeFavorites();
                    }}>{cirkle_lng.favorites}</a>
                </li>

                {
                    cirkle_vars.plugin_active.buddypress_friends &&
                    <li className={filters.scope === 'friends' ? 'current' : ''}>
                        <a onClick={(e) => {
                            e.preventDefault();
                            setScopeFriends();
                        }}>{cirkle_lng.friends}</a>
                    </li>
                }
                {
                    cirkle_vars.plugin_active.buddypress_groups && !props.hideGroupsFilter &&
                    <li className={filters.scope === 'groups' ? 'current' : ''}>
                        <a onClick={(e) => {
                            e.preventDefault();
                            setScopeGroups();
                        }}>{cirkle_lng.groups}</a>
                    </li>
                }
                <li id="activity-filter-select" className="last">
                    <label htmlFor="activity-filter-by">{cirkle_lng.show}</label>
                    <select id="activity-filter-by" name="action" value={action}
                            onChange={handleScopeChange}>
                        <option value="all">{cirkle_lng.everything}</option>
                        <option value="activity_update">{cirkle_lng.status}</option>
                        <option value="activity_share,post_share">{cirkle_lng.shares}</option>
                        {
                            cirkle_vars.plugin_active.mediapress &&
                            <option value="mpp_media_upload">{cirkle_lng.media}</option>
                        }
                        {
                            cirkle_vars.plugin_active.buddypress_friends &&
                            <option value="friendship_created">{cirkle_lng.friendships}</option>
                        }
                        {
                            cirkle_vars.plugin_active.buddypress_groups &&
                            <option value="created_group">{cirkle_lng.new_groups}</option>
                        }
                        {
                            cirkle_vars.plugin_active.bbpress &&
                            <React.Fragment>
                                <option value="bbp_topic_create">{cirkle_lng.forum_topics}</option>
                                <option value="bbp_reply_create">{cirkle_lng.forum_replies}</option>
                            </React.Fragment>
                        }
                    </select>
                </li>
            </ul>
        </div>
    );
}

export default ActivityFilterBar;