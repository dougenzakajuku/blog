<?php
require_once(__DIR__ . '/../utils/SessionKey.php');

/**
 * セッション情報($_SESSION)をカプセル化したシングルトンクラス
 */
final class Session
{
	private static $instance;

	// シングルトンクラスはnewさせないｎのｄでのでprivateｎにｓすｒる
	private function __construct()
	{
	}

	public static function getInstance(): self
	{
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		// まだセッションスタートしてなければスタートする
		self::start();

		return self::$instance;
	}

	private static function start(): void
	{
		if (!isset($_SESSION)) {
			session_start();
		}
	}

	public function appendError(string $errorMessage): void
	{
		$_SESSION[SessionKey::ERROR_KEY][] = $errorMessage;
	}

	public function popAllErrors(): array
	{
		$errors = $_SESSION[self::ERROR_KEY] ?? [];
		$erorrKey = new SessionKey(SessionKey::ERROR_KEY);
		$this->clear($erorrKey);
		return $errors;
	}

	public function existsErrors(): bool
	{
		return !empty($_SESSION[self::ERROR_KEY]);
	}

	public function clear(SessionKey $sessionKey): void
	{
		unset($_SESSION[$sessionKey->value()]);
	}

	public function setFormInputs(array $formInputs): void
	{
		$_SESSION[SessionKey::FORM_INPUTS_KEY] = $formInputs;
	}

	public function getFormInputs(): array
	{
		return $_SESSION[SessionKey::FORM_INPUTS_KEY] ?? [];
	}
}
