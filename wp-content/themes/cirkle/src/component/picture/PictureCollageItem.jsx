import React from 'react';

import PhotoPreview from './PhotoPreview';

class PictureCollageItem extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="thumbs-wrap-item">
                {
                    (this.props.data.more > 0) &&
                    <a className="thumbs-wrap-item-overlay" href={this.props.data.more_link}>
                        <p className="thumbs-wrap-item-overlay-text">+{this.props.data.more}</p>
                    </a>
                }

                <PhotoPreview data={this.props.data}
                              noPopup={(this.props.data?.more) || (this.props.noPopup)}
                />
            </div>
        );
    }
}

export default PictureCollageItem;