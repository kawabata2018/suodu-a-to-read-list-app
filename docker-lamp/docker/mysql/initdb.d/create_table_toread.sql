CREATE TABLE IF NOT EXISTS toread (
    toread_id INT(6) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user_id VARCHAR(16) NOT NULL,
    is_completed BIT(1) NOT NULL DEFAULT 0,
    book_name VARCHAR(255) NOT NULL DEFAULT "",
    author_name VARCHAR(255) NOT NULL DEFAULT "",
    memo VARCHAR(255) NOT NULL DEFAULT "",
    color_tag INT(1) NOT NULL DEFAULT 0,
    total_page INT(6) NOT NULL DEFAULT 10,
    current_page INT(6) NOT NULL DEFAULT 0,
    completed_on DATE,
    target_date DATE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    delete_flag BIT(1) NOT NULL DEFAULT 0,
    CONSTRAINT
        FOREIGN KEY fk_userid(user_id)
        REFERENCES user(user_id)
);

INSERT INTO toread(user_id, is_completed, book_name, author_name, target_date, created_at, updated_at)
VALUES(
    "yomimushi",
    0,
    "完訳水滸伝（岩波文庫）",
    "施耐庵",
    "2020-06-07",
    "2020-05-30 12:00:00",
    "2020-05-31 12:00:00"
);