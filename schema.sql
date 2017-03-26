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

CREATE TABLE `comment` (
    `id` INT AUTO_INCREMENT,
    `text` VARCHAR(255) NOT NULL,
    `creationDate` VARCHAR(255) NOT NULL,
    `userId` INT NOT NULL,
    `barkId` INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (userId) REFERENCES `user`(id),
    FOREIGN KEY (barkId) REFERENCES `bark`(id)
)

CREATE TABLE `message` (
    `id` INT AUTO_INCREMENT,
    `text` VARCHAR(255) NOT NULL,
    `creationDate` VARCHAR(255) NOT NULL,
    `authorId` INT NOT NULL,
    `addresseeId` INT NOT NULL,
    `read` INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (authorId) REFERENCES `user`(id),
    FOREIGN KEY (addresseeId) REFERENCES `user`(id)
)