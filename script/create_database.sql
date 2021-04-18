USE mototour;

CREATE TABLE tour (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(400),
    photo VARCHAR(255)
);