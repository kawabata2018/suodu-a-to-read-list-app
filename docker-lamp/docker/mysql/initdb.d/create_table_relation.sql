CREATE TABLE IF NOT EXISTS relation (
    relation_id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user_id VARCHAR(16) NOT NULL,
    following_id VARCHAR(16) NOT NULL,
    status INT NOT NULL DEFAULT 0,
    related_at TIMESTAMP,
    CONSTRAINT
        FOREIGN KEY (user_id) REFERENCES user(user_id),
        FOREIGN KEY (following_id) REFERENCES user(user_id)
);