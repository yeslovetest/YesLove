const WP_Router = function () {
    const me = {};

    /**
     * Upload member avatar
     * @param {*} callback
     */
    me.uploadMemberAvatar = function (config) {
        const formData = new FormData();

        formData.set('context', 'edit');
        formData.set('action', 'bp_avatar_upload');
        formData.set('file', config.file);

        return jQuery.ajax({
            url: `${cirkle_vars.rest_root}buddypress/v1/members/${config.user_id}/avatar`,
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', cirkle_vars.wp_rest_nonce);
            },
            data: formData,
            contentType: false,
            processData: false
        });
    };

    /**
     * Upload member cover
     * @param {*} callback
     */
    me.uploadMemberCover = function (config) {
        const formData = new FormData();

        formData.set('context', 'edit');
        formData.set('action', 'bp_cover_image_upload');
        formData.set('file', config.file);

        return jQuery.ajax({
            url: `${cirkle_vars.rest_root}buddypress/v1/members/${config.user_id}/cover`,
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', cirkle_vars.wp_rest_nonce);
            },
            data: formData,
            contentType: false,
            processData: false
        });
    };

    /**
     * Upload group avatar
     * @param {*} callback
     */
    me.uploadGroupAvatar = function (config) {
        const formData = new FormData();

        formData.set('context', 'edit');
        formData.set('action', 'bp_avatar_upload');
        formData.set('file', config.file);

        return jQuery.ajax({
            url: `${cirkle_vars.rest_root}buddypress/v1/groups/${config.group_id}/avatar`,
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', cirkle_vars.wp_rest_nonce);
            },
            data: formData,
            contentType: false,
            processData: false
        });
    };

    /**
     * Upload group cover
     * @param {*} callback
     */
    me.uploadGroupCover = function (config) {
        const formData = new FormData();

        formData.set('context', 'edit');
        formData.set('action', 'bp_cover_image_upload');
        formData.set('file', config.file);

        return jQuery.ajax({
            url: `${cirkle_vars.rest_root}buddypress/v1/groups/${config.group_id}/cover`,
            method: 'POST',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', cirkle_vars.wp_rest_nonce);
            },
            data: formData,
            contentType: false,
            processData: false
        });
    };

    /**
     * USER AJAX
     */

    /**
     * Get logged in user member data
     * @param {*} callback
     */
    me.getLoggedInMember = function (config) {
        const data = {
            action: 'cirkle_get_logged_user_member_data_ajax',
            data_scope: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        return jQuery.post(ajaxurl, data);
    };

    /**
     * ACTIVITY AJAX
     */

    /**
     * Get activities
     * @param {*} config
     * @param {*} callback
     */
    me.getActivities = function (config, callback) {
        const data = {
            action: 'cirkle_get_activities_ajax',
            filters: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };
        jQuery.post(ajaxurl, data, callback);
    };

    /**
     * Create activity
     * @param {*} activityData
     * @param {*} callback
     */
    me.createActivity = function (activityData, callback) {
        const formData = new FormData();

        // send creation config
        for (const key in activityData.creation_config) {
            formData.set(`creation_config[${key}]`, activityData.creation_config[key]);
        }

        // send share config if any
        if (activityData.share_config) {
            for (const key in activityData.share_config) {
                formData.set(`share_config[${key}]`, activityData.share_config[key]);
            }
        }

        // send attached media if any
        if (activityData.attached_media) {
            for (const key in activityData.attached_media) {
                formData.set(`attached_media[${key}]`, activityData.attached_media[key]);
            }
        }

        // send uploadable media if any
        if (activityData.uploadable_media) {
            // send files
            for (const file of activityData.uploadable_media.files) {
                formData.append(`uploadable_media[]`, file);
            }

            // send component
            for (const key in activityData.uploadable_media.component) {
                formData.set(`uploadable_media[component][${key}]`, activityData.uploadable_media.component[key]);
            }
        }

        formData.set('action', 'cirkle_create_activity_ajax');
        formData.set('_ajax_nonce', cirkle_vars.ajax_nonce);

        jQuery.ajax({
            url: ajaxurl,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: callback
        });
    };

    /**
     * Delete activity
     * @param {*} activityID
     * @param {*} callback
     */
    me.deleteActivity = function (activityID, callback) {
        const data = {
            action: 'cirkle_delete_activity_ajax',
            activity_id: activityID,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    };

    /**
     * Create activity comment
     * @param {*} commentData
     * @param {*} callback
     */
    me.createActivityComment = function (commentData, callback) {
        const data = {
            action: 'cirkle_create_activity_comment',
            args: {},
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        // args parameters
        if (typeof commentData.activityID !== 'undefined') {
            data.args.activity_id = commentData.activityID;
        }

        if (typeof commentData.parentID !== 'undefined') {
            data.args.parent_id = commentData.parentID;
        }

        if (typeof commentData.content !== 'undefined') {
            data.args.content = commentData.content;
        }
        jQuery.post(ajaxurl, data, callback);
    };

    me.updateActivity = function (args) {
        const data = {
            action: 'cirkle_activity_update',
            args: args,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        return jQuery.post(ajaxurl, data);
    };

    /**
     * Delete activity comment
     * @param {*} config
     */
    me.deleteActivityComment = function (config) {
        const data = {
            action: 'cirkle_activity_comment_delete',
            args: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        // args parameters
        return jQuery.post(ajaxurl, data);
    };

    /**
     * Add activity to user favorites
     * @param {*} config
     * @param {*} callback
     */
    me.addActivityFavorite = function (config, callback) {
        const data = {
            action: 'cirkle_add_favorite_activity_ajax',
            userID: config.userID,
            activityID: config.activityID,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    }

    /**
     * Remove activity from user favorites
     * @param {*} config
     * @param {*} callback
     */
    me.removeActivityFavorite = function (config, callback) {
        const data = {
            action: 'cirkle_remove_favorite_activity_ajax',
            userID: config.userID,
            activityID: config.activityID,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    }

    /**
     * Pin user activity
     * @param {*} config
     * @param {*} callback
     */
    me.pinActivity = function (config, callback) {
        const data = {
            action: 'cirkle_pin_activity_ajax',
            userID: config.userID,
            activityID: config.activityID,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    }

    /**
     * Unpin user activity
     * @param {*} config
     * @param {*} callback
     */
    me.unpinActivity = function (config, callback) {
        const data = {
            action: 'cirkle_unpin_activity_ajax',
            userID: config.userID,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    }

    /**
     * Get user pinned activity
     * @param {*} config
     * @param {*} callback
     */
    me.getPinnedActivity = function (config, callback) {
        const data = {
            action: 'cirkle_get_pinned_activity_ajax',
            userID: config.userID,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    }

    /**
     * REACTION AJAX
     */

    /**
     * Get all reactions
     */
    me.getReactions = function () {
        const data = {
            action: 'rtreact_get_reactions'
        };

        return jQuery.post(ajaxurl, data);
    };

    /**
     * Create a user reaction for an activity
     * @param {*} config
     * @param {*} callback
     */
    me.createActivityUserReaction = function (config, callback) {
        const data = {
            action: 'rtreact_bp_create_activity_user_reaction_ajax',
            args: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };
        jQuery.post(ajaxurl, data, callback);
    };

    /**
     * Delete a user reaction for an activity
     * @param {*} config
     * @param {*} callback
     */
    me.deleteActivityUserReaction = function (config, callback) {
        const data = {
            action: 'rtreact_bp_delete_activity_user_reaction_ajax',
            args: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    };

    /**
     * Create a user reaction for a post comment
     * @param {*} config
     * @param {*} callback
     */
    me.createPostCommentUserReaction = function (config, callback) {
        const data = {
            action: 'rtreact_create_comment_reaction',
            args: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    };

    /**
     * Delete a user reaction for a post comment
     * @param {*} config
     * @param {*} callback
     */
    me.deletePostCommentUserReaction = function (config, callback) {
        const data = {
            action: 'rtreact_delete_comment_reaction',
            args: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    };

    /**
     * Create a user reaction for a post
     * @param {*} config
     * @param {*} callback
     */
    me.createPostUserReaction = function (config, callback) {
        const data = {
            action: 'rtreact_create_post_reaction',
            args: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    };

    /**
     * Delete a user reaction for a post
     * @param {*} config
     * @param {*} callback
     */
    me.deletePostUserReaction = function (config, callback) {
        const data = {
            action: 'rtreact_delete_post_reaction',
            args: config,
            _ajax_nonce: cirkle_vars.ajax_nonce
        };

        jQuery.post(ajaxurl, data, callback);
    };

    return me;
};

export default WP_Router();