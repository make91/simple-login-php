DROP TABLE user_test1;

CREATE TABLE user_test1 (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(30) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
reg_date TIMESTAMP
);

INSERT INTO user_test1
(username, password)
VALUES
('user', '$2y$10$lb9VV9kPIYYDyVcKgB.iwe28igPF7Icbj0qavJ5oFaK1CZsrpw.Ku');
