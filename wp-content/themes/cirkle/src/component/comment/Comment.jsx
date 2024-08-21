import React, { useEffect, useRef, useState } from "react";

import Avatar from "../avatar/Avatar";
import CommentForm from "./CommentForm";
import CommentFormGuest from "./CommentFormGuest";
import CommentActions from "./CommentActions";
import BadgeVerified from "../badge/BadgeVerified";
import {
	filterCommentContentForDisplay,
	filterCommentContentForSave,
} from "../utils/comment/comment-filter";
import CommentFormSimple from "./CommentFormSimple";

const Comment = (props) => {
	const [editingComment, setEditingComment] = useState(false);
	const commentRef = useRef(null);

	const deleteComment = () => {
		props.deleteComment({ comment_id: props.data.id });
	};

	const onReplyButtonClick = () => {
		props.onReplyButtonClick(props.data.id);
	};

	useEffect(() => {
		if (props.data.scrollToMe) {
			commentRef.current.scrollIntoView();
		}
	}, []);

	const startEditingComment = () => {
		setEditingComment(true);
	};

	const stopEditingComment = () => {
		setEditingComment(false);
	};

	const updateComment = (text) => {
		const commentContent = filterCommentContentForSave(text);

		const commentData = {
			...props.data,
			content: commentContent,
		};
		console.log(props.data);
		props.updateComment(commentData, stopEditingComment);
	};

	let commentForm;

	if (props.allowGuest) {
		commentForm = (
			<CommentFormGuest
				parent={props.data.id}
				createComment={props.createComment}
			/>
		);
	}

	if (props.user) {
		commentForm = (
			<CommentForm
				user={props.user}
				parent={props.data.id}
				createComment={props.createComment}
				focus={true}
			/>
		);
	}

	const replyForm = props.data.showReplyForm ? commentForm : "";
	const displayVerifiedMemberBadge =
		props.showVerifiedBadge && props.data.author.verified;
	const filteredCommentContent = filterCommentContentForDisplay(
		props.data.content
	);
	return (
		<div
			ref={commentRef}
			className={`post-comment animate-slide-down reply-${props.depth || 1}`}
		>
			<div className="comment-header">
				{(!props.data.type ||
					props.data.type === "comment" ||
					props.data.type === "activity_comment") && (
					<div className="acomment-avatar">
						{props.data.author.rank && (
							<Avatar
								noBorder
								size="small"
								noLink={props.data.author.link === ""}
								data={props.data.author}
							/>
						)}

						{!props.data.author.rank && (
							<Avatar
								size="small"
								noLink={props.data.author.link === ""}
								data={props.data.author}
							/>
						)}
					</div>
				)}
				<div className="acomment-meta">
					{props.data.author.link !== "" && (
						<a
							className="post-comment-text-author"
							href={props.data.author.link}
						>
							{props.data.author.name}
						</a>
					)}
					{props.data.author.link === "" && (
						<span className="post-comment-text-author">
							{props.data.author.name}
						</span>
					)}
					{displayVerifiedMemberBadge && <BadgeVerified />}
					<div className="mht">
						{cirkle_lng.replied}{" "}
						<span className="activity-time-since">
							<span className="time-since">{props.data.timestamp}</span>
						</span>
					</div>
				</div>
			</div>
			{!editingComment && (
				<div
					className="acomment-content"
					dangerouslySetInnerHTML={{ __html: filteredCommentContent }}
				/>
			)}
			{editingComment && (
				<CommentFormSimple
					text={props.data.content}
					user={props.user}
					parent={props.data.id}
					onSubmit={updateComment}
					onDiscard={stopEditingComment}
					focus={true}
				/>
			)}

			<CommentActions
				data={props.data}
				allowReply={props.user || props.allowGuest}
				user={props.user}
				onReplyButtonClick={onReplyButtonClick}
				onCancelReplyButtonClick={props.onCancelReplyButtonClick}
				onDeleteButtonClick={props.onDeleteButtonClick}
				reactions={props.reactions}
				reactionData={props.reactionData}
				userReaction={props.userReaction}
				createUserReaction={props.createUserReaction}
				deleteUserReaction={props.deleteUserReaction}
				postType={props.postType}
				editingComment={editingComment}
				setEditingComment={setEditingComment}
				deleteComment={deleteComment}
			/>
			{replyForm}
			{props.data.approved == "0" && (
				<p className="post-comment-notification">
					{cirkle_lng.comment_not_approved_message}
				</p>
			)}
		</div>
	);
};

export default Comment;
