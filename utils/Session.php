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
		$errors = $_SESSION[SessionKey::ERROR_KEY] ?? [];
		$erorrKey = new SessionKey(SessionKey::ERROR_KEY);
		$this->clear($erorrKey);
		return $errors;
	}

	public function existsErrors(): bool
	{
		return !empty($_SESSION[SessionKey::ERROR_KEY]);
	}

	public function clear(SessionKey $sessionKey): void
	{
		unset($_SESSION[$sessionKey->value()]);
	}


	public function set(SessionKey $sessionKey, $value): void
	{
		$_SESSION[$sessionKey->value()] = $value;
	}

	public function getFormInputs(): array
	{
		return $_SESSION[SessionKey::FORM_INPUTS_KEY] ?? [];
	}

	public function setRegistedMessage(SessionKey $sessionKey, $registedMessage): void
	{
		$_SESSION[$sessionKey->value()] = $registedMessage;
	}

	public function getRegisted(): string
	{
		$registed = $_SESSION[SessionKey::REGISTED_KEY] ?? "";
		$registedKey = new SessionKey(SessionKey::REGISTED_KEY);
		$this->clear($registedKey);
		return $registed;
	}
}
