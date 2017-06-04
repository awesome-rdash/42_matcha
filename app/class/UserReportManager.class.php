<?php

class UserReportManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function create(UserReport $report) {
		print_r($report);
		$q = $this->_db->prepare('
			INSERT INTO fakeaccounts_reports(id, fromUser, toUserReported, time)
			VALUES(:id, :fromUser, :toUserReported, :time)');
		$q->bindValue(':id', $report->getId(), PDO::PARAM_INT);
		$q->bindValue(':fromUser', $report->getFromUser(), PDO::PARAM_INT);
		$q->bindValue(':toUserReported', $report->getToUserReported(), PDO::PARAM_INT);
		$q->bindValue(':time', time(), PDO::PARAM_INT);

		$q->execute();

		$report->setId($this->_db->lastInsertId());
		return ($report->getId());
	}

	public function ifProfileIsAlreadyReportedByUser($profileReported, $byUser) {
		$query = "SELECT COUNT(*) FROM fakeaccounts_reports WHERE toUserReported = :toUserReported AND fromUser = :fromUser";
		$q = $this->_db->prepare($query);
		$q->bindValue(':toUserReported', $profileReported, PDO::PARAM_INT);
		$q->bindValue(':fromUser', $byUser, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetch();
		return ($result[0]);
	}
}