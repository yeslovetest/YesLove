import React, { useEffect, useRef, useState } from "react";

import app from "../../helper/core";

import CommentList from "./CommentList";
import CommentForm from "./CommentForm";
import CommentFormGuest from "./CommentFormGuest";
import LoaderSpinner from "../loader/LoaderSpinner";
import { updateComments } from "../utils/comment/comment-data";

const AsyncCommentList = (props) => {
	const [comments, setComments] = useState({
		items: [],
		count: props.commentCount,
	});

	const [initialFetch, setInitialFetch] = useState(props.commentCount > 0);

	const commentsWithChildren = useRef([]);
	const preloadedComments = useRef([]);
	const currentPage = useRef(1);

	const _isMounted = useRef(false);

	const iterateComments = (comments, callback, depth = 1) => {
		for (const comment of comments) {
			callback(comment, depth);

			if (typeof comment.children !== "undefined") {
				iterateComments(comment.children, callback, depth + 1);
			}
		}
	};
	const onReplyButtonClick = (commentID) => {
		setComments((previousComments) => {
			const newComments = previousComments.items.slice();

			iterateComments(newComments, (comment) => {
				comment.showReplyForm = comment.id === commentID;
			});

			return {
				...previousComments,
				items: newComments,
			};
		});
	};

	const onCancelReplyButtonClick = () => {
		setComments((previousComments) => {
			const newComments = previousComments.items.slice();

			iterateComments(newComments, (comment) => {
				comment.showReplyForm = false;
			});

			return {
				...previousComments,
				items: newComments,
			};
		});
	};

	const clearChildrenComments = (comments) => {
		for (const comment of comments) {
			if (comment.children instanceof Array && comment.children.length > 0) {
				comment.hasChildren = 0;

				iterateComments(comment.children, () => {
					comment.hasChildren++;
				});

				comment.children = [];
			}
		}
	};

	const getChildrenComments = (parentID) => {
		for (const comment of commentsWithChildren.current) {
			if (comment.id === parentID) {
				const children = comment.children;

				setComments((previousComments) => {
					const newComments = previousComments.items.slice();

					for (const newComment of newComments) {
						if (newComment.id === parentID) {
							newComment.children = children;
							newComment.hasChildren = 0;
							break;
						}
					}

					return {
						...previousComments,
						items: newComments,
					};
				});

				return;
			}
		}
	};

	const getCommentsPage = (callback) => {
		const config = {
			page: currentPage.current,
		};
		currentPage.current += 1;
		props.getComments((requestedComments) => {
			let newRequestedComments = [];
			app.deepExtend(newRequestedComments, requestedComments);
			const newComments = newRequestedComments.slice();
			for (let i = newRequestedComments.length - 1; i >= 0; i--) {
				const comment = newRequestedComments[i];

				for (let j = comments.items.length - 1; j >= 0; j--) {
					const newComment = comments.items[j];
					if (comment.id === newComment.id) {
						newComments.splice(i, 1);
					}
				}
			}
			commentsWithChildren.current =
				commentsWithChildren.current.concat(requestedComments);
			clearChildrenComments(newComments);
			callback(newComments);
		}, config);
	};

	const getMoreComments = () => {
		// dump preloaded comments if any
		if (preloadedComments.current.length > 0) {
			if (_isMounted.current) {
				setComments((previousComments) => {
					const newComments = previousComments.items.concat(
						preloadedComments.current
					);

					getCommentsPage((comments) => {
						preloadedComments.current = comments;
					});

					return {
						...previousComments,
						items: newComments,
					};
				});
			}
			// get comments page and preload comments if there are any left
		} else {
			getCommentsPage((comments) => {
				if (_isMounted.current) {
					setComments((previousComments) => {
						return {
							...previousComments,
							items: previousComments.items.concat(comments),
						};
					});

					setInitialFetch(false);
				}

				getCommentsPage((comments) => {
					preloadedComments.current = comments;
				});
			});
		}
	};

	const createComment = (commentData, callback) => {
		props.createComment(commentData, (response) => {
			if (!response) {
				callback("An error has ocurred, please try again later");
			} else {
				callback(response);
				if (!Number.isNaN(Number.parseInt(response, 10))) {
					newCommentCreated(response);
				}
			}
		});
	};

	const newCommentCreated = (commentID) => {
		props.getComment(commentID, (comment) => {
			setComments((previousComments) => {
				comment.showReplyForm = false;
				const newComments = previousComments.items.slice();
				let commentCount = previousComments.count;
				if (comment.parent == 0) {
					commentCount++;
					if (props.order === "ASC") {
						newComments.push(comment);
					} else if (props.order === "DESC") {
						newComments.unshift(comment);
					}
				} else {
					iterateComments(newComments, (newComment, depth) => {
						if (newComment.id == comment.parent) {
							if (typeof newComment.children === "undefined") {
								newComment.children = [];
							}
							if (props.order === "ASC") {
								newComment.children.push(comment);
							} else if (props.order === "DESC") {
								newComment.children.unshift(comment);
							}
							newComment.showReplyForm = false;
							return;
						}
					});
				}
				return {
					items: newComments,
					count: commentCount,
				};
			});
		});
	};

	const updateComment = (commentData, callback) => {
		const updateCommentPromise = props.updateComment(commentData);

		updateCommentPromise
			.done((response) => {
				console.log(response);
				props.getComment(commentData.id, (updatedCommentData) => {
					onCommentUpdate(updatedCommentData);
					callback();
				});
			})
			.fail((error) => {});
	};

	const onCommentUpdate = (newCommentData) => {
		setComments((previousComments) => {
			return {
				...previousComments,
				items: updateComments(previousComments.items, newCommentData),
			};
		});
	};

	const deleteCommentStatic = (commentID) => {
		setComments((previousComments) => {
			let newComments = [];

			app.deepExtend(newComments, previousComments.items);

			let deletedCommentCount = 0;

			// only need top level comment count
			for (const comment of newComments) {
				if (comment.id === commentID) {
					deletedCommentCount = 1;
					break;
				}
			}

			newComments = iterateCommentsFilter(newComments, commentID);
			return {
				items: newComments,
				count: previousComments.count - deletedCommentCount,
			};
		});
	};

	const deleteComment = (config, callback) => {
		const deleteCommentPromise = props.deleteComment(config);
		deleteCommentPromise
			.done((response) => {
				if (response) {
					deleteCommentStatic(config.comment_id);
				} else {
					callback(false);
				}
			})
			.fail((error) => {
				callback(false);
			});
	};

	const iterateCommentsFilter = (comments, commentID) => {
		const filteredComments = comments.filter(
			(comment) => comment.id !== commentID
		);

		return filteredComments.map((comment) => {
			if (typeof comment.children !== "undefined") {
				comment.children = iterateCommentsFilter(comment.children, commentID);
			}

			return comment;
		});
	};

	useEffect(() => {
		if (!_isMounted.current) {
			_isMounted.current = true;
		}

		return () => {
			_isMounted.current = false;
		};
	}, []);
    //
	useEffect(() => {
		if (props.commentCount > 0) {
			props.getCommentCount((commentCount) => {
				setComments((previousComments) => {
					return {
						...previousComments,
						count: commentCount,
					};
				});

				getMoreComments();
			});
		}
	}, []);

	let commentForm;

	if (props.allowGuest) {
		commentForm = (
			<CommentFormGuest
				updateCfActive={props.updateCfActive}
				createComment={createComment}
			/>
		);
	}

	if (props.user) {
		commentForm = (
			<CommentForm
				updateCfActive={props.updateCfActive}
				user={props.user}
				userFriends={props.user.friends}
				createComment={createComment}
			/>
		);
	}

	let userCanComment = props.user;

	const isActivityComment = props.postType === "activity",
		isGroupActivityComment =isActivityComment && props.parentData.component === "groups";
	return (
		<div className="post-comment">
			<div className="activity-comments">
				{initialFetch && <LoaderSpinner />}

				{!initialFetch && (
					<>
						{props.isCfActive &&
							props.formPosition === "top" &&
							userCanComment && (
								<div className="cklac-form ac-form root">{commentForm}</div>
							)}
						{comments.items.length > 0 && (
							<CommentList
								comments={comments.items}
								user={props.user}
								userCanComment={userCanComment}
								createComment={createComment}
								updateComment={updateComment}
								deleteComment={deleteComment}
								onReplyButtonClick={onReplyButtonClick}
								onCancelReplyButtonClick={onCancelReplyButtonClick}
								commentCount={comments.count}
								getMoreComments={getMoreComments}
								getChildrenComments={getChildrenComments}
								entityData={props.entityData}
								parentData={props.parentData}
								reactions={props.reactions}
								createUserReaction={props.createUserReaction}
								deleteUserReaction={props.deleteUserReaction}
								postType={props.postType}
								disableComments={props.disableComments}
								showVerifiedBadge={props.showVerifiedBadge}
							/>
						)}
						{!props.disableComments &&
							props.formPosition === "bottom" &&
							userCanComment &&
							commentForm}
					</>
				)}
			</div>
		</div>
	);
};

export default AsyncCommentList;
