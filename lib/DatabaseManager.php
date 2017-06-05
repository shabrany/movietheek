<?php

class DB
{

	protected static $config = array('host' => 'localhost');

	private static $instance = null;

	public $pdo = null;

	private $rowsAffected = 0;

	public $lastInsertedId;

	/**
	 * Init PDO connection
	 */
	public function __construct() {
		try {
			$host = self::$config['host'];
			$dbname = self::$config['dbname'];
			$stringConnection = "mysql:host={$host};dbname={$dbname}";
			$this->pdo = new PDO($stringConnection, self::$config['username'], self::$config['password']);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			print_r($e->getMessage());
		}
	}

	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Set the required configuration to connet the mysql server
	 *
	 * @param string $key
	 * @param string $value
	 */
	public static function setConfig($key, $value) {
		self::$config[$key] = $value;
	}

	/**
	 * Return the result items from a query
	 *
	 * @param string $query
	 * @return array
	 */
	public function getResults($query) {
		$results = array();
		try {
			$stmt = $this->pdo->query($query);
			if ($stmt) {
				$results = $stmt->fetchAll();
			}
		} catch(PDOException $e) {
			throw $e;
		}

		return $results;
	}

	/**
	 * Execute an SQL query using PDO prepared statments
	 *
	 * @param string $query
	 * @param array $params
	 */
	public function exec($query, $params = array()) {
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($params);
			$this->rowsAffected = $stmt->rowCount();
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * Run an SQL query without using prepared statements
	 *
	 * @param string $sql
	 * @return int The number of affected rows
	 */
	public function runSQL($sql) {
		$rowsAffected = 0;
		try {
			$rowsAffected = $this->pdo->exec($sql);
		} catch (PDOException $e) {
			throw $e;
		}
		return $rowsAffected;
	}

	/**
	 * Retrieve a single row from query
	 *
	 * @param string $query
	 * @param array $params
	 * @return array
	 */
	public function getRow($query, $params = [])
	{
		$result = [];
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($params);
			$result = $stmt->fetch();
		} catch (Exception $e) {
			throw $e;
		}
		return $result;
	}

	/**
	 *
	 * @param string $table
	 * @param array $data
	 */
	public function insert($table, $data) {

		$fields = array_keys($data);
		$tableFields = implode(',', $fields);
		$placeholders = ':' . implode(', :', $fields);

		$query = "INSERT into {$table} ({$tableFields}) VALUES ({$placeholders})";

		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($data);
			$this->rowsAffected = $stmt->rowCount();
			$this->lastInsertId = $this->pdo->lastInsertId();
		} catch (PDOException $e) {
			echo $e->getMessage() . '';
			echo $query;
			exit(0);
		}

		return $this->rowsAffected;
	}

	/**
	 * Update a record in the given table.
	 *
	 * @param strign $table
	 * @param array $data
	 * @return int
	 */
	public function update($table, $data)
	{
		if (empty($data['id'])) {
			throw new Exception('Key ID was not given or empty');
		}

		$sets = [];
		foreach ($data as $key => $value) {
			if ($key == 'id') continue;
			$sets[] = $key . '=:' . $key;
		}

		try {
			$query = "UPDATE {$table} SET " . implode(', ', $sets). "  WHERE id=:id";
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($data);
			$this->rowsAffected = $stmt->rowCount();
		} catch (PDOException $e) {
			throw $e;
		}

		return $this->rowsAffected;
	}

	/**
	 * Return the number of rows affected
	 *
	 * @return void
	 */
	public function getRowsAffected()
	{
		return $this->rowsAffected;
	}
}
