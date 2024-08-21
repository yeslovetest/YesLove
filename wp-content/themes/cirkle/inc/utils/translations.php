<?php
function cirkle_translation_get() {
	return [
		'replied'                                   => esc_html__('replied', 'cirkle'),
		/**
		 * Backend - Theme Activation
		 */
		'activate'                                  => esc_html__('Activate!', 'cirkle'),
		'activating'                                => esc_html__('Activating...', 'cirkle'),
		'activation_form_wrong_pc_or_token_error'   => esc_html__('Wrong Purchase Code or Access Token.', 'cirkle'),

		/**
		 * Backend - Plugin Installer
		 */
		'required_plugins_install_button_text'      => esc_html__('Install / Update / Activate Plugins', 'cirkle'),
		'processing'                                => esc_html__('Processing...', 'cirkle'),

		/**
		 * Header Search
		 */
		'search_placeholder'                        => esc_html__('Search here for posts', 'cirkle'),
		'search_placeholder_bp'                     => esc_html__('Search here for people, groups and posts', 'cirkle'),
		'search_placeholder_bp_no_groups'           => esc_html__('Search here for people and posts', 'cirkle'),
		'members'                                   => esc_html__('Members', 'cirkle'),
		'no_members_found'                          => esc_html__('No members found', 'cirkle'),
		'groups'                                    => esc_html__('Groups', 'cirkle'),
		'no_groups_found'                           => esc_html__('No groups found', 'cirkle'),
		'posts'                                     => esc_html__('Posts', 'cirkle'),
		'no_posts_found'                            => esc_html__('No posts found', 'cirkle'),
		'by'                                        => esc_html_x('By', 'by author_name', 'cirkle'),

		/**
		 * Header Friend Requests
		 */
		'friend_requests'                           => esc_html__('Friend Requests', 'cirkle'),
		'received'                                  => esc_html__('Received', 'cirkle'),
		'sent'                                      => esc_html__('Sent', 'cirkle'),
		'no_friend_requests_received'               => esc_html__('No friend requests received', 'cirkle'),
		'no_friend_requests_sent'                   => esc_html__('No friend requests sent', 'cirkle'),
		'view_all_friend_requests'                  => esc_html__('View all Friend Requests', 'cirkle'),

		/**
		 * Header Messages
		 */
		'messages'                                  => esc_html__('Messages', 'cirkle'),
		'no_messages_received'                      => esc_html__('No messages received', 'cirkle'),
		'view_all_messages'                         => esc_html__('View all Messages', 'cirkle'),

		/**
		 * Header Notifications
		 */
		'notifications'                             => esc_html__('Notifications', 'cirkle'),
		'no_notifications_received'                 => esc_html__('No notifications received', 'cirkle'),
		'view_all_notifications'                    => esc_html__('View all Notifications', 'cirkle'),

		/**
		 * Filterable List
		 */
		'post_no_results_title'                     => esc_html__('No posts found', 'cirkle'),
		'post_no_results_text'                      => esc_html__('Please create some posts or try with another filter!', 'cirkle'),
		'member_no_results_title'                   => esc_html__('No members found', 'cirkle'),
		'member_no_results_text'                    => esc_html__('Please try with another filter!', 'cirkle'),
		'group_no_results_title'                    => esc_html__('No groups found', 'cirkle'),
		'group_no_results_text'                     => esc_html__('Please try with another filter!', 'cirkle'),
		'activity_no_results_title'                 => esc_html__('No posts found', 'cirkle'),
		'activity_no_results_text'                  => esc_html__('Please create some posts or try with another filter!', 'cirkle'),
		'showing_results_text_1'                    => esc_html_x('Showing', '"showing" n results out of m total', 'cirkle'),
		'showing_results_text_2'                    => esc_html_x('out of', 'showing n results "out of" m total', 'cirkle'),

		/**
		 * Post Filters
		 */
		'category'                                  => esc_html__('Category', 'cirkle'),
		'all_categories'                            => esc_html__('All Categories', 'cirkle'),
		'filter_by'                                 => esc_html_x('Filter By', 'narrow a search by some criteria', 'cirkle'),
		'date'                                      => esc_html_x('Date', 'e.g. (10/08/2020)', 'cirkle'),
		'popularity'                                => esc_html__('Popularity', 'cirkle'),
		'order_by'                                  => esc_html__('Order By', 'cirkle'),
		'ascending'                                 => esc_html__('Ascending', 'cirkle'),
		'descending'                                => esc_html__('Descending', 'cirkle'),
		'filter_action'                             => esc_html_x('Filter', 'to narrow a search', 'cirkle'),

		/**
		 * Grid Filters
		 */
		'grid_filter'                               => [
			'big'   => esc_html_x('Big Grid', 'how the content is displayed on screen', 'cirkle'),
			'small' => esc_html_x('Small Grid', 'how the content is displayed on screen', 'cirkle'),
			'list'  => esc_html_x('List Grid', 'how the content is displayed on screen', 'cirkle')
		],

		/**
		 * Post Preview
		 */
		'read_more'                                 => esc_html__('Read More...', 'cirkle'),
		'comment'                                   => esc_html_x('Comment', 'a comment', 'cirkle'),
		'comments'                                  => esc_html__('Comments', 'cirkle'),
		'share'                                     => esc_html_x('Share', 'a share', 'cirkle'),
		'shares'                                    => esc_html_x('Shares', '0 / 2 or more replies', 'cirkle'),

		/**
		 * Reaction Filters
		 */
		'no_reactions'                              => esc_html_x('No Reactions!', 'show everything', 'cirkle'),
		'all'                                       => esc_html_x('All', 'show everything', 'cirkle'),
		'more_reactions_text_1'                     => esc_html_x('and', '"and" n more reactions', 'cirkle'),
		'more_reactions_text_2'                     => esc_html_x('more...', 'and n "more" reactions', 'cirkle'),

		/**
		 * Widget Tabs
		 */
		'newest'                                    => esc_html__('Newest', 'cirkle'),
		'popular'                                   => esc_html__('Popular', 'cirkle'),
		'active'                                    => esc_html_x('Active', 'user activity', 'cirkle'),

		/**
		 * Photos Widget
		 */
		'no_photos_found'                           => esc_html__('No photos found', 'cirkle'),

		/**
		 * Friends Widget
		 */
		'friends'                                   => esc_html__('Friends', 'cirkle'),
		'no_friends_found'                          => esc_html__('No friends found', 'cirkle'),
		'find_friends'                              => esc_html__('Find Friends', 'cirkle'),
		'see_all_friends'                           => esc_html__('See all Friends', 'cirkle'),

		/**
		 * Activity Form
		 */
		'status_update'                             => esc_html__('Status Update', 'cirkle'),
		'post_in'                                   => esc_html__('Post In', 'cirkle'),
		'my_profile'                                => esc_html__('My Profile', 'cirkle'),
		'privacy'                                   => esc_html__('Privacy', 'cirkle'),
		'public'                                    => esc_html__('Public', 'cirkle'),
		'activity_form_placeholder_1'               => esc_html_x('Hi', '(Activity Form) Placeholder text before user name', 'cirkle'),
		'activity_form_placeholder_2'               => esc_html_x('Write something here, use &#64; to mention someone...', '(Activity Form) Placeholder text after user name', 'cirkle'),
		'add_photo'                                 => esc_html__('Add Photo', 'cirkle'),
		'upload_photo'                              => esc_html__('Upload Photo', 'cirkle'),
		'discard'                                   => esc_html__('Discard', 'cirkle'),
		'post_action'                               => esc_html_x('Post', 'to post something', 'cirkle'),
		'activity_form_empty_error'                 => esc_html__('Please enter some text or add a photo!', 'cirkle'),
		'upload_form_empty_error'                   => esc_html__('Please add a photo to upload!', 'cirkle'),

		/**
		 * Activity Filters
		 */
		'all_updates'                               => esc_html_x('All Updates', 'to show all post updates', 'cirkle'),
		'mentions'                                  => esc_html__('Mentions', 'cirkle'),
		'favorites'                                 => esc_html__('Favorites', 'cirkle'),
		'scope'                                     => esc_html__('Scope', 'cirkle'),
		'show'                                      => esc_html__('Show', 'cirkle'),
		'everything'                                => esc_html__('Everything', 'cirkle'),
		'status'                                    => esc_html__('Status', 'cirkle'),
		'media'                                     => esc_html__('Media', 'cirkle'),
		'friendships'                               => esc_html__('Friendships', 'cirkle'),
		'new_groups'                                => esc_html__('New Groups', 'cirkle'),

		/**
		 * Activity Settings
		 */
		'add_favorite'                              => esc_html__('Add Favorite', 'cirkle'),
		'remove_favorite'                           => esc_html__('Remove Favorite', 'cirkle'),
		'pin_to_top'                                => esc_html__('Pin to Top', 'cirkle'),
		'unpin_from_top'                            => esc_html__('Unpin from Top', 'cirkle'),
		'delete_post'                               => esc_html__('Delete Post', 'cirkle'),
		'delete_activity_message_title'             => esc_html__('Delete Post', 'cirkle'),
		'delete_activity_message_text'              => esc_html__('Are you sure you want to delete this post?', 'cirkle'),

		/**
		 * Activity
		 */
		'in_the_group'                              => esc_html__('in the group', 'cirkle'),


		/**
		 * Content Actions
		 */
		'comment'                                   => esc_html_x('Comment', 'a comment', 'cirkle'),
		'comments'                                  => esc_html__('Comments', 'cirkle'),
		'share'                                     => esc_html_x('Share', 'a share', 'cirkle'),
		'shares'                                    => esc_html_x('Shares', '0 / 2 or more shares', 'cirkle'),


		/**
		 * Post Footer
		 */
		'react'                                     => esc_html_x('React!', 'to react to something', 'cirkle'),
		'comment_action'                            => esc_html_x('Comment', 'to comment on something', 'cirkle'),
		'share_action'                              => esc_html_x('Share', 'to share something', 'cirkle'),

		/**
		 * Comment Form
		 */
		'submit'                                    => esc_html__('Submit', 'cirkle'),
		'leave_a_comment'                           => esc_html__('Leave a Comment', 'cirkle'),
		'your_reply'                                => esc_html__('Your Reply', 'cirkle'),
		'post_reply'                                => esc_html__('Post Reply', 'cirkle'),
		'reply_action'                              => esc_html_x('Reply', 'to reply to something', 'cirkle'),
		'edit_comment'                              => esc_html_x('Edit', 'to reply to something', 'cirkle'),
		'delete_comment'                            => esc_html_x('Delete', 'to reply to something', 'cirkle'),
		'cancel_action'                             => esc_html_x('Cancel', 'to cancel something', 'cirkle'),
		'load'                                      => esc_html__('Load', 'cirkle'),
		'reply'                                     => esc_html_x('Reply', 'a reply', 'cirkle'),
		'replies'                                   => esc_html_x('Replies', '0 / 2 or more replies', 'cirkle'),
		'load_more_comments'                        => esc_html__('Load More Comments', 'cirkle'),
		'comment_empty_message'                     => esc_html__('Please enter a comment', 'cirkle'),
		'comment_not_approved_message'              => esc_html__('Your comment is awaiting moderation and will be visible when approved', 'cirkle'),

		/**
		 * Group Filters
		 */
		'search_groups'                             => esc_html__('Search Groups', 'cirkle'),
		'order_by'                                  => esc_html__('Order By', 'cirkle'),
		'alphabetical'                              => esc_html__('Alphabetical', 'cirkle'),
		'newest_groups'                             => esc_html__('Newest Groups', 'cirkle'),
		'recently_active'                           => esc_html__('Recently Active', 'cirkle'),

		/**
		 * Group Preview
		 */
		'group'                                     => esc_html__('Group', 'cirkle'),
		'member'                                    => esc_html__('Member', 'cirkle'),
		'post'                                      => esc_html_x('Post', 'a post', 'cirkle'),
		'banned'                                    => esc_html_x('Banned', 'banned from something', 'cirkle'),

		/**
		 * Message Box
		 */
		'accept'                                    => esc_html__('Accept', 'cirkle'),
		'cancel'                                    => esc_html__('Cancel', 'cirkle'),
		'continue'                                  => esc_html__('Continue', 'cirkle'),

		/**
		 * Group Actions
		 */
		'join_group'                                => esc_html__('Join Group', 'cirkle'),
		'leave_group'                               => esc_html__('Leave Group', 'cirkle'),
		'remove_member'                             => esc_html__('Remove Member', 'cirkle'),
		'remove_invitation'                         => esc_html__('Remove Invitation', 'cirkle'),
		'reject_invitation'                         => esc_html__('Reject Invitation', 'cirkle'),
		'accept_invitation'                         => esc_html__('Accept Invitation', 'cirkle'),
		'ban_member'                                => esc_html__('Ban Member', 'cirkle'),
		'unban_member'                              => esc_html__('Unban Member', 'cirkle'),
		'promote_to_admin'                          => esc_html__('Promote to Admin', 'cirkle'),
		'promote_to_mod'                            => esc_html__('Promote to Mod', 'cirkle'),
		'demote_to_mod'                             => esc_html__('Demote to Mod', 'cirkle'),
		'demote_to_member'                          => esc_html__('Demote to Member', 'cirkle'),
		'manage_groups'                             => esc_html__('Manage Groups', 'cirkle'),

		/**
		 * Member Filters
		 */
		'search_members'                            => esc_html__('Search Members', 'cirkle'),
		'order_by'                                  => esc_html__('Order By', 'cirkle'),
		'alphabetical'                              => esc_html__('Alphabetical', 'cirkle'),
		'newest_members'                            => esc_html__('Newest Members', 'cirkle'),
		'recently_active'                           => esc_html__('Recently Active', 'cirkle'),

		/**
		 * Member Preview
		 */
		'post'                                      => esc_html_x('Post', 'a post', 'cirkle'),
		'friend'                                    => esc_html__('Friend', 'cirkle'),
		'no_social_networks_linked'                 => esc_html__('No social networks linked', 'cirkle'),
		'no_badges_unlocked'                        => esc_html__('No badges unlocked', 'cirkle'),

		/**
		 * Member Actions
		 */
		'add_friend'                                => esc_html__('Add Friend', 'cirkle'),
		'remove_friend'                             => esc_html__('Remove Friend', 'cirkle'),
		'accept_friend'                             => esc_html__('Accept Friend Request', 'cirkle'),
		'reject_friend'                             => esc_html__('Reject Friend Request', 'cirkle'),
		'withdraw_friend'                           => esc_html__('Cancel Friend Request', 'cirkle'),
		'send_message'                              => esc_html__('Send Message', 'cirkle'),

		/**
		 * Activity Media List
		 */
		'browse'                                    => esc_html__('Browse', 'cirkle'),
		'photos'                                    => esc_html__('Photos', 'cirkle'),
		'photos_no_results_title'                   => esc_html__('No photos found', 'cirkle'),
		'photos_no_results_text'                    => esc_html__('There aren\'t any uploaded photos!', 'cirkle'),
		'upload_photos'                             => esc_html__('Upload Photos', 'cirkle'),
		'select_all'                                => esc_html__('Select All', 'cirkle'),
		'unselect_all'                              => esc_html__('Unselect All', 'cirkle'),
		'delete'                                    => esc_html__('Delete', 'cirkle'),

		/**
		 * Settings
		 */
		'my_profile'                                => esc_html__('My Profile', 'cirkle'),
		'save_changes'                              => esc_html__('Save Changes', 'cirkle'),
		'saving'                                    => esc_html__('Saving...', 'cirkle'),

		/**
		 * Profile Info Settings
		 */
		'profile_info'                              => esc_html__('Profile Info', 'cirkle'),
		'change_avatar'                             => esc_html__('Change Avatar', 'cirkle'),
		'change_cover'                              => esc_html__('Change Cover', 'cirkle'),
		'avatar_upload_error'                       => esc_html__('Avatar Upload Error', 'cirkle'),
		'cover_upload_error'                        => esc_html__('Cover Upload Error', 'cirkle'),
		'select_an_option'                          => esc_html__('Select an Option', 'cirkle'),

		/**
		 * Social Settings
		 */
		'social_networks'                           => esc_html__('Social Networks', 'cirkle'),
		'no_social_info_available'                  => esc_html__('No social info available', 'cirkle'),

		/**
		 * Notification Settings
		 */
		'notifications_received_no_results_title'   => esc_html__('No notifications received', 'cirkle'),
		'notifications_received_no_results_text'    => esc_html__('If you receive notifications they will appear here!', 'cirkle'),
		'mark_as_read'                              => esc_html__('Mark as Read', 'cirkle'),
		'accept'                                    => esc_html__('Accept', 'cirkle'),
		'cancel'                                    => esc_html__('Cancel', 'cirkle'),
		'delete_selected_message'                   => esc_html__('Are you sure you want to delete all selected items?', 'cirkle'),

		/**
		 * Message Settings
		 */
		'inbox'                                     => esc_html__('Inbox', 'cirkle'),
		'sentbox'                                   => esc_html__('Sentbox', 'cirkle'),
		'starred'                                   => esc_html_x('Starred', 'favorites', 'cirkle'),
		'new_message'                               => esc_html__('New Message', 'cirkle'),
		'started'                                   => esc_html__('Started', 'cirkle'),
		'add_friend_placeholder'                    => esc_html__('Use &#64; to add a friend...', 'cirkle'),
		'search_messages'                           => esc_html__('Search Messages', 'cirkle'),
		'write_a_message'                           => esc_html__('Write a Message...', 'cirkle'),
		'no_messages_found'                         => esc_html__('No messages found', 'cirkle'),
		'message_search_no_results'                 => esc_html__('No messages match your search', 'cirkle'),
		'star_action'                               => esc_html_x('Star', 'favorite something', 'cirkle'),
		'unstar'                                    => esc_html_x('Unstar', 'unfavorite something', 'cirkle'),
		'delete_item_message'                       => esc_html__('Are you sure you want to delete this?', 'cirkle'),
		'you'                                       => esc_html__('You', 'cirkle'),

		/**
		 * Friend Requests Settings
		 */
		'friend_requests_received'                  => esc_html__('Friend Requests Received', 'cirkle'),
		'friend_requests_received_no_results_title' => esc_html__('No friend requests received', 'cirkle'),
		'friend_requests_received_no_results_text'  => esc_html__('If you receive friend requests they will appear here!', 'cirkle'),
		'friend_requests_sent'                      => esc_html__('Friend Requests Sent', 'cirkle'),
		'friend_requests_sent_no_results_title'     => esc_html__('No friend requests sent', 'cirkle'),
		'friend_requests_sent_no_results_text'      => esc_html__('If you send friend requests they will appear here!', 'cirkle'),

		/**
		 * Account Info Settings
		 */
		'account'                                   => esc_html__('Account', 'cirkle'),
		'account_info'                              => esc_html__('Account Info', 'cirkle'),
		'no_account_info_available'                 => esc_html__('No account info available', 'cirkle'),

		/**
		 * Change Password Settings
		 */
		'change_password'                           => esc_html__('Change Password', 'cirkle'),
		'enter_your_current_password'               => esc_html__('Enter your Current Password', 'cirkle'),
		'your_new_password'                         => esc_html__('Your New Password', 'cirkle'),
		'confirm_new_password'                      => esc_html__('Confirm New Password', 'cirkle'),
		'error'                                     => esc_html__('Error', 'cirkle'),
		'change_password_error_title'               => esc_html__('Change Password Error', 'cirkle'),
		'change_password_error_text'                => esc_html__('Couldn\'t change password. Please try again later', 'cirkle'),
		'current_password_mismatch_error_title'     => esc_html__('Incorrect Password', 'cirkle'),
		'current_password_mismatch_error_text'      => esc_html__('Entered current password doesn\'t match your password. Please make sure to enter your current password correctly', 'cirkle'),
		'new_password_mismatch_error_title'         => esc_html__('New Password Mismatch', 'cirkle'),
		'new_password_mismatch_error_text'          => esc_html__('New password field and new password confirmation field don\'t match. Please make sure to enter the same password in both fields', 'cirkle'),

		/**
		 * Manage Groups Settings
		 */
		'manage_group'                              => esc_html__('Manage Group', 'cirkle'),
		'manage_groups'                             => esc_html__('Manage Groups', 'cirkle'),
		'cant_manage_groups_message'                => esc_html__('You can\'t manage any groups yet!', 'cirkle'),
		'create_group'                              => esc_html__('Create Group!', 'cirkle'),
		'create_new_group'                          => esc_html__('Create New Group', 'cirkle'),
		'create_new_group_text'                     => esc_html__('Share your passion with others!', 'cirkle'),
		'start_creating'                            => esc_html__('Start Creating!', 'cirkle'),
		'creating'                                  => esc_html__('Creating...', 'cirkle'),
		'group_creator'                             => esc_html__('Group Creator', 'cirkle'),
		'group_admin'                               => esc_html__('Group Admin', 'cirkle'),
		'group_mod'                                 => esc_html__('Group Mod', 'cirkle'),

		'group_info'        => esc_html__('Group Info', 'cirkle'),
		'group_name'        => esc_html__('Group Name', 'cirkle'),
		'group_slug'        => esc_html__('Group Slug (what you see on the URL)', 'cirkle'),
		'group_description' => esc_html__('Group Description', 'cirkle'),

		'avatar_and_cover' => esc_html__('Avatar and Cover', 'cirkle'),

		'administrators'          => esc_html__('Administrators', 'cirkle'),
		'mods'                    => esc_html__('Mods', 'cirkle'),
		'banned_members'          => esc_html__('Banned Members', 'cirkle'),
		'no_mods_found'           => esc_html__('No mods found', 'cirkle'),
		'no_banned_members_found' => esc_html__('No banned members found', 'cirkle'),

		'delete_group'              => esc_html__('Delete Group', 'cirkle'),
		'delete_group_text'         => esc_html__('Deleting a group will remove all its content, this action cannot be undone.', 'cirkle'),
		'delete_group_confirmation' => esc_html__('Are you sure you want to delete this group?', 'cirkle'),

		'required_fields_message'               => esc_html__('Please fill all required fields', 'cirkle'),
		'save_error_message'                    => esc_html__('Error when saving, please try again later', 'cirkle'),
		'discard_all'                           => esc_html__('Discard All', 'cirkle'),

		/**
		 * Send Invitations Settings
		 */
		'send_invitations'                      => esc_html__('Send Invitations', 'cirkle'),
		'send_invitations_no_results_title'     => esc_html__('No groups', 'cirkle'),
		'send_invitations_no_results_text_1'    => esc_html__('You don\'t belong to any groups. Create or join a group first!', 'cirkle'),
		'send_invitations_no_results_text_2'    => esc_html__('You don\'t belong to any groups which you can send invitations from', 'cirkle'),
		'select_the_group'                      => esc_html__('Select the Group', 'cirkle'),
		'select_your_friends'                   => esc_html__('Select your Friends', 'cirkle'),
		'send_invitations_friends_no_results'   => esc_html__('You don\'t have any friends that can be invited to this group', 'cirkle'),
		'sending'                               => esc_html__('Sending...', 'cirkle'),
		'pending_invitations'                   => esc_html__('Pending Invitations', 'cirkle'),
		'pending_invitations_no_results_title'  => esc_html__('No invitations sent', 'cirkle'),
		'pending_invitations_no_results_text'   => esc_html__('If you send invitations they will appear here!', 'cirkle'),

		/**
		 * Received Invitations Settings
		 */
		'received_invitations'                  => esc_html__('Received Invitations', 'cirkle'),
		'received_invitations_no_results_title' => esc_html__('No invitations received', 'cirkle'),
		'received_invitations_no_results_text'  => esc_html__('If you receive invitations they will appear here!', 'cirkle'),
		'invited_by'                            => esc_html__('Invited By', 'cirkle'),

		'forum_topics'              => esc_html__('Forum Topics', 'cirkle'),
		'forum_replies'             => esc_html__('Forum Replies', 'cirkle'),
		/**
		 * Login Form Popup
		 */
		'register'                  => esc_html__('Register', 'cirkle'),
		'login'                     => esc_html__('Login', 'cirkle'),
		'login_and_register'        => esc_html__('Login &amp; Register', 'cirkle'),
		'account_login'             => esc_html__('Account Login', 'cirkle'),
		'username_or_email'         => esc_html__('Username or Email', 'cirkle'),
		'password'                  => esc_html__('Password', 'cirkle'),
		'remember_me'               => esc_html__('Remember Me', 'cirkle'),
		'login_to_your_account'     => esc_html__('Login to your Account', 'cirkle'),
		'authenticating'            => esc_html__('Authenticating...', 'cirkle'),
		'wrong_user_message'        => esc_html__('Wrong username or password.', 'cirkle'),
		'generic_error'             => esc_html__('An error has ocurred. Please try again later.', 'cirkle'),
		'create_your_account'       => esc_html__('Create your Account!', 'cirkle'),
		'your_email'                => esc_html__('Your Email', 'cirkle'),
		'username'                  => esc_html__('Username', 'cirkle'),
		'repeat_password'           => esc_html__('Repeat Password', 'cirkle'),
		'register_now'              => esc_html__('Register Now!', 'cirkle'),
		'registering'               => esc_html__('Registering...', 'cirkle'),
		'registration_complete'     => esc_html__('Registration Complete!', 'cirkle'),
		'invalid_email_message'     => esc_html__('Email entered is invalid', 'cirkle'),
		'password_mismatch_message' => esc_html__('Passwords don\'t match, please enter the same password in both fields', 'cirkle'),
		'username_exists_message'   => esc_html__('Username already exists!, please select another one', 'cirkle')
	];
}
