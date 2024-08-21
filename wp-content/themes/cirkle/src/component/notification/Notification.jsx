const Notification = (props) => {
    return (
        <div className="notification-section animate-slide-down">
            <p className="notification-section-title">{props.title}</p>
            <p className="notification-section-text">{props.text}</p>
        </div>
    );
}

export default Notification;