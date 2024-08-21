import React from 'react';

import PictureCollageItem from './PictureCollageItem';

class PictureCollageRow extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className={`thumbs-wrap-row ${this.props.modifiers || ''}`}>
                {
                    this.props.data.map((item) => {
                        return (
                            <PictureCollageItem key={item.id}
                                                data={item}
                                                noPopup={this.props.noPopup}
                            />
                        );
                    })
                }
            </div>
        );
    }
}

export default PictureCollageRow;