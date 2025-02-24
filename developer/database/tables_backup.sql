CREATE TABLE webhook_message_secrets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message_data_id VARCHAR(255),
    secret TEXT,
    FOREIGN KEY (message_data_id) REFERENCES webhook_message_data(id)
);
