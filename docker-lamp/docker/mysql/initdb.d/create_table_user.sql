CREATE TABLE IF NOT EXISTS user (
    user_id VARCHAR(16) NOT NULL PRIMARY KEY,
    user_name VARCHAR(64) NOT NULL DEFAULT "よみむし",
    password VARCHAR(255) NOT NULL,
    profile VARCHAR(255) NOT NULL DEFAULT "よみむし大好き",
    icon_path VARCHAR(255),
    created_at TIMESTAMP,
    is_protected BIT(1) NOT NULL DEFAULT 1,
    delete_flag BIT(1) NOT NULL DEFAULT 0
);

INSERT INTO user
VALUES(
    "yomimushi",
    "よみむし",
    "hogehoge",
    "よみむし大好き",
    NULL,
    NULL,
    0,
    0
);