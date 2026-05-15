<?php

declare(strict_types=1);

namespace Src\Repositories;

require_once __DIR__ . "/../../config/DB.php";
require_once __DIR__ . "/../Entities/Quiz.php";

use PDO;
use Src\Entities\Quiz;

class QuizRepository
{
	private PDO $pdo;

	public function __construct(?PDO $pdo = null)
	{
		$this->pdo = $pdo ?? \DB::connect();
	}

	public function create(Quiz $quiz)
	{
		$stmt = $this->pdo->prepare(
			"INSERT INTO quizzes(title, description, accesscode, teacher_id)
			 VALUES (?, ?, ?, ?)"
		);

		return $stmt->execute([
			$quiz->getTitle(),
			$quiz->getDescription(),
			$quiz->getAccessCode(),
			$quiz->getTeacherId()
		]);
	}

	public function allByTeacher(int $teacherId)
	{
		$stmt = $this->pdo->prepare(
			"SELECT * FROM quizzes WHERE teacher_id = ?"
		);

		$stmt->execute([$teacherId]);

		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function findById(int $id)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE id = ?");
		$stmt->execute([$id]);

		$quiz = $stmt->fetch(PDO::FETCH_OBJ);

		return $quiz ?: null;
	}

	public function findByAccessCode(string $code)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM quizzes WHERE accesscode = ?");
		$stmt->execute([$code]);

		$quiz = $stmt->fetch(PDO::FETCH_OBJ);

		return $quiz ?: null;
	}

	public function findByCode(string $code)
	{
		return $this->findByAccessCode($code);
	}

	public function getFullQuizData(int $quizId): array
	{
		$sql = "SELECT
					q.id AS question_id,
					q.question,
					a.id AS answer_id,
					a.answer_text,
					a.is_correct
				FROM questions q
				LEFT JOIN answers a ON q.id = a.question_id
				WHERE q.quiz_id = ?
				ORDER BY q.id ASC, a.id ASC";

		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([$quizId]);

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$questions = [];

		foreach ($rows as $row) {
			$questionId = (int)$row['question_id'];

			if (!isset($questions[$questionId])) {
				$questions[$questionId] = [
					'id' => $questionId,
					'text' => $row['question'],
					'answers' => []
				];
			}

			if (!empty($row['answer_id'])) {
				$questions[$questionId]['answers'][] = [
					'id' => (int)$row['answer_id'],
					'text' => $row['answer_text'],
					'is_correct' => (int)($row['is_correct'] ?? 0)
				];
			}
		}

		return array_values($questions);
	}

	public function update(int $id, string $title, string $description)
	{
		$stmt = $this->pdo->prepare(
			"UPDATE quizzes SET title = ?, description = ? WHERE id = ?"
		);

		return $stmt->execute([$title, $description, $id]);
	}

	public function delete(int $id)
	{
		$stmt = $this->pdo->prepare("DELETE FROM quizzes WHERE id = ?");

		return $stmt->execute([$id]);
	}

}
