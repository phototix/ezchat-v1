CREATE TABLE webhook_events (
    id VARCHAR(255) PRIMARY KEY,
    event VARCHAR(50),
    session VARCHAR(255),
    engine VARCHAR(50),
    environment_version VARCHAR(50),
    environment_engine VARCHAR(50),
    environment_tier VARCHAR(50),
    environment_browser VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE webhook_users (
    id VARCHAR(255) PRIMARY KEY,
    pushName VARCHAR(255)
);

CREATE TABLE webhook_payloads (
    id VARCHAR(255) PRIMARY KEY,
    event_id VARCHAR(255),
    timestamp INT,
    from_user VARCHAR(255),
    to_user VARCHAR(255),
    body TEXT,
    hasMedia BOOLEAN,
    ack INT,
    ackName VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE webhook_message_data (
    id VARCHAR(255) PRIMARY KEY,
    payload_id VARCHAR(255),
    viewed BOOLEAN,
    message_body TEXT,
    message_type VARCHAR(50),
    timestamp INT,
    notifyName VARCHAR(255),
    from_user VARCHAR(255),
    to_user VARCHAR(255),
    ack INT,
    invis BOOLEAN,
    isNewMsg BOOLEAN,
    star BOOLEAN,
    kicNotified BOOLEAN,
    recvFresh BOOLEAN,
    isFromTemplate BOOLEAN,
    labels TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE webhook_message_secrets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message_data_id VARCHAR(255),
    secret BYTEA,
);
