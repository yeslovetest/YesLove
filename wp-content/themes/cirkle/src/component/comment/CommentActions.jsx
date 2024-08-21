import React, { useEffect, useRef, useState } from "react";

import ReactionMetaLineSmall from "../reaction/ReactionMetaLineSmall";
import CommentReactionOption from "./CommentReactionOption";
import { getUserCommentPermissions } from "../utils/comment/comment-permission";

import plugins from "../../helper/plugins";
import LoaderSpinnerSmall from "../loader/LoaderSpinnerSmall";

const CommentActions = (props) => {
	const [processingDelete, setProcessingDelete] = useState(false);

	const parentActivityGroup = props.parentData ? props.parentData.group : false;
	const userCommentPermissions = getUserCommentPermissions(
		props.user,
		props.data,
		parentActivityGroup
	);

	const deleteComment = () => {
		// return if already processing delete
		if (processingDelete) {
			return;
		}
		if (!confirm(cirkle_lng.delete_item_message)) {
			return;
		}

		setProcessingDelete(true);

		const commentData = {
			id: props.data.id,
			hasChildren: props.data.hasChildren,
		};

		props.deleteComment(commentData, () => {
			setProcessingDelete(false);
		});
	};

	return (
		<div className="comment-actions">
			<div className="comment-action">
				{props.reactionData.length > 0 && (
					<ReactionMetaLineSmall modifiers="small" data={props.reactionData} />
				)}

				{props.user &&
					["activity", "post"].includes(props.postType) &&
					cirkle_vars.plugin_active.rtreact && (
						<CommentReactionOption
							reactions={props.reactions}
							userReaction={props.userReaction}
							createUserReaction={props.createUserReaction}
							deleteUserReaction={props.deleteUserReaction}
						/>
					)}
			</div>
			{props.allowReply && (
				<div className="comment-action">
					{userCommentPermissions.edit && (
						<>
							{!props.editingComment && (
								<div className="meta-line">
									<p
										className="meta-line-link light"
										onClick={() => {
											props.setEditingComment(true);
										}}
									>
										{cirkle_lng.edit_comment}
									</p>
								</div>
							)}
							{props.editingComment && (
								<div className="meta-line">
									<p
										className="meta-line-link light"
										onClick={() => {
											props.setEditingComment(false);
										}}
									>
										{cirkle_lng.cancel_action}
									</p>
								</div>
							)}
						</>
					)}
					{userCommentPermissions.delete && (
						<>
							<div className="meta-line">
								<p onClick={deleteComment} className="meta-line-link light">
									{cirkle_lng.delete_comment}
								</p>
								{processingDelete && <LoaderSpinnerSmall />}
							</div>
						</>
					)}
					{!props.data.showReplyForm && (
						<div className="meta-line">
							<p
								className="meta-line-link light"
								onClick={props.onReplyButtonClick}
							>
								{cirkle_lng.reply_action}
							</p>
						</div>
					)}
					{props.data.showReplyForm && (
						<div className="meta-line">
							<p
								className="meta-line-link light"
								onClick={props.onCancelReplyButtonClick}
							>
								{cirkle_lng.cancel_action}
							</p>
						</div>
					)}
				</div>
			)}
		</div>
	);
};

export default CommentActions;
