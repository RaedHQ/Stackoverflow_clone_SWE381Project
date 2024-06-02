CREATE DATABASE stackoverflow_database;

USE stackoverflow_database;

CREATE TABLE User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE Question (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
);

CREATE TABLE Answer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL,
    question_id INT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (question_id) REFERENCES Question(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
);

CREATE TABLE Question_Comment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL,
    q_id INT NOT NULL,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE,
    CONSTRAINT fk_comment_question FOREIGN KEY (q_id) REFERENCES Question(id) ON DELETE CASCADE
);

CREATE TABLE Answer_Comment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL,
    a_id INT NOT NULL,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE,
    CONSTRAINT fk_comment_answer FOREIGN KEY (a_id) REFERENCES answer(id) ON DELETE CASCADE
);

CREATE TABLE Rating (
    id INT AUTO_INCREMENT PRIMARY KEY,
    answer_id INT,
    user_id INT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (answer_id) REFERENCES Answer(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES User(id) ON DELETE CASCADE
);

CREATE INDEX idx_question_user_id ON Question(user_id);
CREATE INDEX idx_answer_user_id ON Answer(user_id);
CREATE INDEX idx_comment_user_id ON Comment(user_id);
CREATE INDEX idx_commentable_id ON Comment(commentable_id);
CREATE INDEX idx_rating_user_id ON Rating(user_id);
CREATE INDEX idx_rating_answer_id ON Rating(answer_id);
