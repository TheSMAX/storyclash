-- database/migrations/create_tables.sql

CREATE TABLE feeds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE instagram_sources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feed_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    fan_count INT NOT NULL DEFAULT 0,
    FOREIGN KEY (feed_id) REFERENCES feeds(id) ON DELETE CASCADE
);

CREATE TABLE tiktok_sources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feed_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    fan_count INT NOT NULL DEFAULT 0,
    FOREIGN KEY (feed_id) REFERENCES feeds(id) ON DELETE CASCADE
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feed_id INT NOT NULL,
    url VARCHAR(512) NOT NULL,
    FOREIGN KEY (feed_id) REFERENCES feeds(id) ON DELETE CASCADE
);

-- database/seeds/insert_test_data.sql

INSERT INTO feeds (name) VALUES 
('Influencer A'),
('Influencer B'),
('Influencer C'),
('Influencer D'),
('Influencer E');

INSERT INTO instagram_sources (feed_id, name, fan_count) VALUES
(1, 'insta_a', 1000),
(2, 'insta_b', 2500),
(3, 'insta_c', 3000),
(4, 'insta_d', 400),
(5, 'insta_e', 1500);

INSERT INTO tiktok_sources (feed_id, name, fan_count) VALUES
(1, 'tiktok_a', 2000),
(2, 'tiktok_b', 3500),
(3, 'tiktok_c', 1800),
(4, 'tiktok_d', 500),
(5, 'tiktok_e', 2200);

INSERT INTO posts (feed_id, url) VALUES
(1, 'http://post1.com'),
(1, 'http://post2.com'),
(2, 'http://post3.com'),
(3, 'http://post4.com'),
(5, 'http://post5.com');
