import React from 'react';

import app from '../../helper/core';

class Reactionable extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            reactionData: props.reactionData,
            userReaction: false
        };

        this.createUserReaction = this.createUserReaction.bind(this);
        this.deleteUserReaction = this.deleteUserReaction.bind(this);
    }

    createUserReaction(reaction_id) {
        if (this.state.userReaction && (this.state.userReaction.id === reaction_id)) {
            // reaction already selected
            return;
        }

        const config = {
            user_id: this.props.user.id,
            reaction_id: parseInt(reaction_id, 10)
        };

        app.deepExtend(config, this.props.entityData);

        // create user reaction
        this.props.createUserReaction(config, (response) => {
            if (typeof this.props.updateReactionData === 'function') {
                this.props.updateReactionData(this.state.reactionData);
            }
        });

        this.deleteUserReactionStatic();

        this.createUserReactionStatic(reaction_id);

        this.getUserReaction();

        this.sortUserReactions();
    }

    deleteUserReaction() {

        const config = {
            user_id: this.props.user.id
        };

        app.deepExtend(config, this.props.entityData);

        // delete user reaction
        this.props.deleteUserReaction(config, (response) => {
            // check if deleted correctly
        });

        this.deleteUserReactionStatic();

        this.setState({
            userReaction: false
        });

        this.sortUserReactions();
    }

    deleteUserReactionStatic() {
        this.setState((state, props) => {
            const reactions = [];
            app.deepExtend(reactions, state.reactionData);

            for (let i = 0; i < state.reactionData.length; i++) {
                const reaction = state.reactionData[i];

                for (let j = 0; j < reaction.users.length; j++) {
                    const user = reaction.users[j];
                    // found user
                    if (user.id === this.props.user.id) {

                        const newReactionCount = Number.parseInt(reaction.reaction_count, 10) - 1;

                        if (newReactionCount === 0) {
                            // remove reaction
                            reactions.splice(i, 1);
                        } else {
                            reactions[i].users.splice(j, 1);
                            reactions[i].reaction_count = newReactionCount + '';
                        }


                        return {
                            reactionData: reactions
                        };
                    }
                }
            }
        });
    }

    sortUserReactions(order = 'DESC') {
        this.setState((state, props) => {
            const reactionData = [];
            app.deepExtend(reactionData, state.reactionData);

            const sortedReactionData = reactionData.sort((firstEl, secondEl) => {
                if (firstEl.reaction_count < secondEl.reaction_count) {
                    return -1;
                }

                if (firstEl.reaction_count > secondEl.reaction_count) {
                    return 1;
                }

                return 0;
            });

            return {
                reactionData: sortedReactionData
            };
        });
    }

    createUserReactionStatic(reaction_id) {
        this.setState((state, props) => {
            const reactions = [];

            app.deepExtend(reactions, state.reactionData);

            for (let i = 0; i < state.reactionData.length; i++) {
                const reaction = state.reactionData[i];

                // found reaction
                if (reaction.id === reaction_id) {
                    reactions[i].reaction_count = (Number.parseInt(reactions[i].reaction_count, 10) + 1) + '';
                    reactions[i].users.push(this.props.user);

                    return {
                        reactionData: reactions
                    };
                }
            }

            for (const reaction of this.props.reactions) {
                // reaction found
                if (reaction.id === reaction_id) {
                    const newReaction = {};
                    app.deepExtend(newReaction, reaction);
                    newReaction.reaction_count = '1';
                    newReaction.users = [];
                    newReaction.users.push(this.props.user);

                    reactions.unshift(newReaction);

                    return {
                        reactionData: reactions
                    };
                }
            }
        });
    }

    getUserReaction() {
        this.setState((state, props) => {
            for (const reaction of state.reactionData) {
                for (const user of reaction.users) {
                    // user found
                    if (user.id === this.props.user.id) {
                        return {
                            userReaction: {
                                id: reaction.id,
                                image_url: reaction.image_url,
                                name: reaction.name
                            }
                        };
                    }
                }
            }

            return {};
        });
    }

    componentDidMount() {
        if (this.props.user) {
            this.getUserReaction();
        }
    }

    componentDidUpdate(prevProps) {
        if (prevProps.user !== this.props.user) {
            this.getUserReaction();
        }
    }

    render() {
        return (
            this.props.children(this.state.reactionData, this.state.userReaction, this.createUserReaction, this.deleteUserReaction)
        );
    }
}

export default Reactionable;
