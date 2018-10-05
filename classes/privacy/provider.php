<?php
// To comply with GDPR requirements [for code compliance, see docs.moodle.org/dev/Privacy_API].
namespace block_remaining_lesson_timer\privacy;

defined('MOODLE_INTERNAL') || die();

// This plugin does not store any personal user data.
class provider implements
    \core_privacy\local\metadata\null_provider {

    /**
     * This plugin does not store any personal user data.
     */
    public static function get_reason() : string {
        return 'privacy:metadata';
    }
}

