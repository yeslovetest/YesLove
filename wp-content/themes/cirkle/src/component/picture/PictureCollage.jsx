import React from 'react';

import PictureCollageRow from './PictureCollageRow';

class PictureCollage extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const collageRows = [];

        if (this.props.data.length === 1) {
            collageRows.push({
                data: this.props.data,
                modifier: 'full'
            });
        } else if ((this.props.data.length % 2) === 0) {
            const rowCount = this.props.data.length / 2;

            for (let i = 0; i < rowCount; i++) {
                collageRows.push({
                    data: this.props.data.slice(i * 2, (i * 2) + 2),
                    modifier: 'medium'
                });
            }
        } else {
            if (this.props.data.length === 3) {
                collageRows.push({
                    data: this.props.data
                });
            } else {
                if (this.props.data.length === 5) {
                    if (this.props.metadata) {
                        this.props.data[this.props.data.length - 1].more = this.props.metadata.more;
                        this.props.data[this.props.data.length - 1].more_link = this.props.metadata.more_link;
                    }

                    collageRows.push({
                        data: this.props.data.slice(0, 2),
                        modifier: 'medium'
                    });

                    collageRows.push({
                        data: this.props.data.slice(2)
                    });
                }
            }
        }
        return (
            <div className="thumbs-wrap">
                {
                    collageRows.map((row, i) => {
                        return (
                            <PictureCollageRow key={i}
                                               data={row.data}
                                               modifiers={row.modifier || ''}
                            />
                        );
                    })
                }
            </div>
        );
    }
}

export default PictureCollage;