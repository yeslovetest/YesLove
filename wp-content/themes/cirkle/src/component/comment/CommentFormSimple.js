import React, {useState, useRef} from 'react';

import ExpandableTextarea from '../form/ExpandableTextarea';

import app from '../../helper/core';

function CommentFormSimple(props) {
    const previousText = useRef(props.text ? app.stripHTML(props.text) : '');

    const [replyText, setReplyText] = useState(previousText.current);
    const [disabled, setDisabled] = useState(false);
    const [error, setError] = useState(false);
    const [loading, setLoading] = useState(false);

    const handleSubmit = () => {
        // if no text entered, show error
        if (replyText === '') {
            setError(cirkle_lng.comment_empty_message);
            return;
        }

        // if text didn't change, discard
        if (replyText === previousText.current) {
            props.onDiscard();
            return;
        }
        if (loading) {
            return;
        }

        setLoading(true);
        setDisabled(true);
        setError(false);
        props.onSubmit(replyText);
    };

    const handleReplyTextChange = (e) => {
        setReplyText(e.target.value);
    };

    return (
        <div className="post-comment-form">
            <form className="form comment-form">
                <ExpandableTextarea name='replyText'
                                    value={replyText}
                                    modifiers='small'
                                    maxLength={500}
                                    userFriends={props.user.friends}
                                    handleChange={handleReplyTextChange}
                                    loading={loading}
                                    focus={props.focus}
                                    disabled={disabled}
                                    error={error}
                                    submitOnEnter
                                    submitButton
                                    onSubmit={handleSubmit}
                />
            </form>
            {
                error && <p className="post-comment-form-error" dangerouslySetInnerHTML={{__html: error}}/>
            }
        </div>
    );
}

export {CommentFormSimple as default};