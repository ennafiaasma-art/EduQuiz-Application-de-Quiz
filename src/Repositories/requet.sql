-- ============================================================
-- EduQuiz Database (with Roles Table)
-- ============================================================

CREATE DATABASE IF NOT EXISTS eduquiz;
USE eduquiz;

-- ------------------------------------------------------------
-- TABLE: roles
-- ------------------------------------------------------------
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Insert default roles
INSERT INTO roles (name) VALUES
('teacher'),
('student');

-- ------------------------------------------------------------
-- TABLE: users
-- ------------------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
    ON DELETE RESTRICT
);

-- ------------------------------------------------------------
-- TABLE: quizzes
-- ------------------------------------------------------------
CREATE TABLE quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    accesscode VARCHAR(10) NOT NULL UNIQUE,
    teacher_id INT NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES users(id)
    ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- TABLE: questions
-- ------------------------------------------------------------
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    question TEXT NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
    ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- TABLE: answers
-- ------------------------------------------------------------
CREATE TABLE answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_id INT NOT NULL,
    answer_text VARCHAR(255) NOT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (question_id) REFERENCES questions(id)
    ON DELETE CASCADE
);

-- ------------------------------------------------------------
-- TABLE: results
-- ------------------------------------------------------------
CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    student_id INT NOT NULL,
    score INT NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
    ON DELETE CASCADE,

    FOREIGN KEY (student_id) REFERENCES users(id)
    ON DELETE CASCADE
);
    ----------------------------------INSERT donnees----------------------




INSERT INTO users (name, email, password, role_id) VALUES
('Ahmed Teacher', 'ahmed@eduquiz.com', '123456', 1),
('Sara Teacher', 'sara@eduquiz.com', '123456', 1),

('Youssef Student', 'youssef@eduquiz.com', '123456', 2),
('Salma Student', 'salma@eduquiz.com', '123456', 2),
('Omar Student', 'omar@eduquiz.com', '123456', 2);






INSERT INTO quizzes (title, description, accesscode, teacher_id) VALUES
(
    'PHP Basics Quiz',
    'Quiz about PHP fundamentals',
    'PHP101',
    1
),
(
    'Networking Quiz',
    'Quiz about computer networks',
    'NET202',
    2
);





INSERT INTO questions (quiz_id, question) VALUES
(1, 'What does PHP stand for ?'),
(1, 'Which symbol is used for variables in PHP ?'),

(2, 'What is the role of DNS ?'),
(2, 'What device connects different networks together ?');







INSERT INTO answers (question_id, answer_text, is_correct) VALUES

-- Question 1
(1, 'HyperText Preprocessor', TRUE),
(1, 'Personal Home Page', FALSE),
(1, 'Private Home Processor', FALSE),

-- Question 2
(2, '$', TRUE),
(2, '#', FALSE),
(2, '&', FALSE),

-- Question 3
(3, 'Translate domain names into IP addresses', TRUE),
(3, 'Store web pages', FALSE),
(3, 'Protect the network', FALSE),

-- Question 4
(4, 'Router', TRUE),
(4, 'Switch', FALSE),
(4, 'Printer', FALSE);







INSERT INTO results (quiz_id, student_id, score) VALUES
(1, 3, 85),
(1, 4, 70),
(2, 5, 90),
(2, 3, 60);