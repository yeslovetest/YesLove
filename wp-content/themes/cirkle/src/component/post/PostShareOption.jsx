import React from 'react';

import plugins from '../../helper/plugins';
import ShareOptionList from "../reaction/ShareOptionList";

class PostShareOption extends React.Component {
    constructor(props) {
        super(props);

        this.shareBoxRef = React.createRef();
        this.shareBoxTriggerRef = React.createRef();
    }

    componentDidMount() {
        plugins.createDropdown({
            triggerElement: this.shareBoxTriggerRef.current,
            containerElement: this.shareBoxRef.current,
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
            <li className="post-option post-share">
                <div ref={this.shareBoxTriggerRef} className="post-option">
                    <i className="icofont-share"></i>
                    <span className="post-option-text">{cirkle_lng.share_action}</span>
                </div>
                <ShareOptionList ref={this.shareBoxRef}
                                    data={this.props.reactions}
                                    createUserReaction={this.props.createUserReaction}
                                    modifiers={`${this.props.simpleOptions ? 'small' : ''}`}
                />
            </li>
        );
    }
}

export default PostShareOption;