<?php

/*
 * You can empty out this file, if you are certain that you match all requirements.
 */

/*
 * You can remove this if you are confident that your PHP version is sufficient.
 */
if (version_compare(PHP_VERSION, '7.2.0') < 0) {
    trigger_error('Your PHP version must be equal or higher than 7.2.0 to use CakePHP.', E_USER_ERROR);
}

/*
 * You can remove this if you are confident you have intl installed.
 */
if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}

/*
 * You can remove this if you are confident you have proper version of intl.
 */
if (version_compare(INTL_ICU_VERSION, '50.1', '<')) {
    trigger_error(
        'ICU >= 50.1 is needed to use CakePHP. Please update the `libicu` package of your system.' . PHP_EOL,
        E_USER_ERROR
    );
}

/*
 * You can remove this if you are confident you have mbstring installed.
 */
if (!extension_loaded('mbstring')) {
    trigger_error('You must enable the mbstring extension to use CakePHP.', E_USER_ERROR);
}
