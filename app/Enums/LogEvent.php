<?php

namespace App\Enums;

class LogEvent
{
    public const REGISTERED = 'registered';
    public const TRIED_TO_REREGISTER = 'tried_to_reregister';
    public const LOGGED_IN = 'logged_in';
    public const FAILED_LOGIN = 'failed_login';
    public const INVALID_LOGIN = 'invalid_login';
    public const VERIFIED_EMAIL = 'verified_email';
    public const VIEWED_REPORT = 'viewed_report';
    public const SUBMITTED_REPORT = 'submitted_report';
    public const REQUESTED_PASSWORD_RESET = 'requested_password_reset';
}
