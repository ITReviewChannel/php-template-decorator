<?php

namespace ITReview;

/**
 * Интерфейс логгера.
 *
 * @package ITReview
 */
interface LoggerInterface
{
    /**
     * Создание.
     *
     * @param int $userID Идентификатор пользователя.
     * @param string $userEmail E-mail пользователя.
     * @param int $time UNIX-время.
     */
    public function create(int $userID, string $userEmail, int $time): void;
}

/**
 * Декорируемый логгер.
 *
 * @package ITReview
 */
final class Logger implements LoggerInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(int $userID, string $userEmail, int $time): void
    {
        echo 'Добавление записи в БД.' . PHP_EOL;
    }
}

/**
 * Декоратор E-mail оповещения.
 *
 * @package ITReview
 */
final class EmailLogger implements LoggerInterface
{
    /**
     * @var LoggerInterface $logger Декорируемый логгер.
     */
    private LoggerInterface $logger;

    /**
     * Конструктор.
     *
     * @param LoggerInterface $logger Декорируемый объект.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function create(int $userID, string $userEmail, int $time): void
    {
        $this->logger->create($userID, $userEmail, $time);

        echo 'Отправка E-mail.' . PHP_EOL;
    }
}

/**
 * Декоратор SMS оповещения.
 *
 * @package ITReview
 */
final class SmsLogger implements LoggerInterface
{
    /**
     * @var LoggerInterface $logger Декорируемый логгер.
     */
    private LoggerInterface $logger;

    /**
     * Конструктор.
     *
     * @param LoggerInterface $logger Декорируемый объект.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function create(int $userID, string $userEmail, int $time): void
    {
        $this->logger->create($userID, $userEmail, $time);

        echo 'Отправка SMS.' . PHP_EOL;
    }
}

$logger = new SmsLogger(new EmailLogger(new Logger()));
$logger->create(100, 'test1@mail.ru', 2983842);
