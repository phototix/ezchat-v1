CREATE TABLE webhook_payloads (
    id VARCHAR(255) PRIMARY KEY,
    event_id VARCHAR(255),
    timestamp INT,
    session VARCHAR(255),
    from_user VARCHAR(255),
    notifyName VARCHAR(255),
    to_user VARCHAR(255),
    body TEXT,
    hasMedia VARCHAR(255),
    ack INT,
    ackName VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


DROP TABLE db_ezchat.webhook_events;
DROP TABLE db_ezchat.webhook_users;
DROP TABLE db_ezchat.webhook_payloads;
DROP TABLE db_ezchat.webhook_message_data;
DROP TABLE db_ezchat.webhook_message_secrets;