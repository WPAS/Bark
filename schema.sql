CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `username` VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY ('id')
)

CREATE TABLE `bark` (
    `id` INT AUTO_INCREMENT,
    `text` VARCHAR(255) NOT NULL,
    `creationDate` VARCHAR(255) NOT NULL,
    `userId` INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (userId) REFERENCES `user`(id)
)