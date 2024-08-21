const BadgeVerified = (props) => {
    return (
        <span dangerouslySetInnerHTML={{__html: cirkle_vars.bp_verified_member_badge}}></span>
    );
}

export default BadgeVerified;