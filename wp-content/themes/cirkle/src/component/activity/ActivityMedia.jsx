import PictureCollage from "../picture/PictureCollage";
import React from "react";

const ActivityMedia = (props) => {
    if (props.data.uploaded_media.data.length > 1) {
        return (
            <PictureCollage data={props.data.uploaded_media.data}
                            metadata={props.data.uploaded_media.metadata}/>
        )
    } else {
        const media = props.data.uploaded_media.data[0];
        if (media.type === 'video') {
            if (media.is_remote && media.is_oembed && media.oembed.content) {
                return <div className="cirkle-single-media-wrap video oembed"
                            dangerouslySetInnerHTML={{__html: ` ${media.oembed.content}`}}>
                </div>
            } else if (media.link) {
                return <div className="cirkle-single-media-wrap video">
                    <video src={media.link} controls/>
                </div>
            }
        } else if (media.type === 'audio') {
            return <div className="cirkle-single-media-wrap audio">
                <audio src={media.link} controls/>
            </div>
        } else {
            return <div className="cirkle-single-media-wrap photo">
                <img src={media.link} alt={media.title}/>
            </div>
        }
    }

}

export default ActivityMedia;