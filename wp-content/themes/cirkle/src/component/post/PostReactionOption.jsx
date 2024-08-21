import React from 'react';
import plugins from '../../helper/plugins';
import ReactionOptionList from '../reaction/ReactionOptionList';

class PostReactionOption extends React.Component {
    constructor(props) {
        super(props);

        this.reactionOptionsDropdownTriggerRef = React.createRef();
        this.reactionOptionsDropdownContentRef = React.createRef();
    }

    componentDidMount() {
        plugins.createDropdown({
            triggerElement: this.reactionOptionsDropdownTriggerRef.current,
            containerElement: this.reactionOptionsDropdownContentRef.current,
            triggerEvent: 'hover',
            offset: {
                bottom: 32,
                left: -16
            },
            animation: {
                type: 'translate-bottom',
                speed: .3,
                translateOffset: {
                    vertical: 20
                }
            },
            closeOnDropdownClick: true
        });
    }

    render() {
        return (
            <li className="post-react">
                <div ref={this.reactionOptionsDropdownTriggerRef}
                     className={`post-option ${this.props.userReaction ? 'reaction-active' : ''}`}
                     {...(this.props.userReaction && {onClick: this.props.deleteUserReaction})}
                >
                    {this.props.userReaction &&
                    <><img className="post-option-image" src={this.props.userReaction.image_url}
                           alt={`reaction-${this.props.userReaction.name}`}/><span className="reaction-name bold">{this.props.userReaction.name}</span></>}
                    {!this.props.userReaction && <span className="post-option-text">{cirkle_lng.react}</span>}
                </div>

                <ReactionOptionList ref={this.reactionOptionsDropdownContentRef}
                                    data={this.props.reactions}
                                    createUserReaction={this.props.createUserReaction}
                                    modifiers={`${this.props.simpleOptions ? 'small' : ''}`}
                />
            </li>
        );
    }
}

export default PostReactionOption;
