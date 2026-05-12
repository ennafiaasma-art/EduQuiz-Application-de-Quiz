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
