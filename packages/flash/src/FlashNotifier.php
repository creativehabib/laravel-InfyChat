<?php

namespace Laracasts\Flash;

use Illuminate\Session\Store;

class FlashNotifier
{
    /**
     * The session store implementation.
     */
    protected Store $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Flash a general message to the session.
     */
    public function message(string $message, string $level = 'info'): void
    {
        $this->session->flash('flash_notification', [
            'message' => $message,
            'level' => $level,
        ]);
    }

    /**
     * Flash an information message.
     */
    public function info(string $message): void
    {
        $this->message($message, 'info');
    }

    /**
     * Flash a success message.
     */
    public function success(string $message): void
    {
        $this->message($message, 'success');
    }

    /**
     * Flash an error message.
     */
    public function error(string $message): void
    {
        $this->message($message, 'danger');
    }

    /**
     * Flash a warning message.
     */
    public function warning(string $message): void
    {
        $this->message($message, 'warning');
    }
}
