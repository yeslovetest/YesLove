import React from 'react';

import Avatar from '../avatar/Avatar';
import ExpandableTextarea from '../form/ExpandableTextarea';

class CommentForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            replyText: '',
            disabled: false,
            error: false,
            loading: false
        };

        this.inputRef = React.createRef();

        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    lockInput() {
        this.setState({
            disabled: true
        });
    }

    unlockInput() {
        this.setState({
            disabled: false
        });
    }

    clearInput() {
        this.setState({
            replyText: '',
            error: false
        });
    }

    isEmpty(string) {
        return string === '';
    }

    handleSubmit() {
        if (this.isEmpty(this.state.replyText)) {
            this.setState({
                error: cirkle_lng.comment_empty_message
            });

            return;
        }

        const commentData = {
            parentID: this.props.parent ? this.props.parent : 0,
            content: this.state.replyText.trim(),
            userID: this.props.user.id,
            author: this.props.user.name
        };

        this.lockInput();

        // console.log('COMMENT FORM - COMMENT DATA: ', commentData);

        this.setState({
            loading: true,
            error: false
        });

        this.props.createComment(commentData, (response) => {
            // console.log('COMMENT FORM - FORM CREATE COMMENT WITH ID: ', response);

            // if comment was not created
            if (Number.isNaN(Number.parseInt(response, 10))) {
                // console.log('COMMENT FORM - COULDN\'T CREATE COMMENT: ', response);

                this.unlockInput();

                this.setState({
                    error: response,
                    loading: false
                });

                return;
            }

            this.setState({
                loading: false
            });

            this.unlockInput();
            this.clearInput();
            if (typeof this.props.updateCfActive === 'function') {
                this.props?.updateCfActive(false);
            }
        });
    }

    handleChange(e) {
        this.setState({
            replyText: e.target.value
        });
    }

    render() {
        return (
            <div className="post-comment-form">
                <form className="form comment-form">
                    <div className="ac-reply-avatar"><Avatar noBorder data={this.props.user}/></div>
                    <div className="ac-reply-content">
                        <ExpandableTextarea name='replyText'
                                            value={this.state.replyText}
                                            label={cirkle_lng.your_reply}
                                            modifiers='small'
                                            maxLength={500}
                                            userFriends={this.props.user.friends}
                                            handleChange={this.handleChange}
                                            loading={this.state.loading}
                                            focus={this.props.focus}
                                            disabled={this.state.disabled}
                                            error={this.state.error}
                                            submitOnEnter
                                            submitButton
                                            onSubmit={this.handleSubmit}
                        />
                    </div>
                    {
                        this.state.error &&
                        <p className="post-comment-form-error" dangerouslySetInnerHTML={{__html: this.state.error}}></p>
                    }
                </form>
            </div>
        );
    }
}

export default CommentForm;