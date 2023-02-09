<?php
/**
 * This file is part of Totara Learn
 *
 * Copyright (C) 2022 onwards Totara Learning Solutions LTD
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Gihan Hewaralalage <gihan.hewaralalage@totaralearning.com>
 * @package totara_notification
 */

defined('MOODLE_INTERNAL') || die();

use mod_facetoface\totara_notification\resolver\booking_confirmed;
use totara_core\extended_context;
use totara_notification\delivery\channel_helper;
use totara_notification\entity\notification_event_log as notification_event_log_entity;
use totara_notification\entity\notification_log as notification_log_entity;
use totara_notification\model\notification_delivery_log as model;
use totara_notification\model\notification_event_log;
use totara_notification\model\notification_log as notification_log_model;
use totara_notification\rb\traits\notification_log_trait;
use totara_notification\rb\traits\notification_event_log_trait;

/**
 * Notification delivery log report source.
 *
 * Class rb_source_notification_delivery_log
 */
class rb_source_notification_delivery_log extends rb_base_source {
    use notification_event_log_trait;
    use notification_log_trait;

    /**
     * Constructor.
     *
     * @param mixed $groupid
     * @param rb_global_restriction_set|null $globalrestrictionset
     */
    public function __construct($groupid, rb_global_restriction_set $globalrestrictionset = null) {
        if ($groupid instanceof rb_global_restriction_set) {
            throw new coding_exception('Wrong parameter orders detected during report source instantiation.');
        }
        // Remember the active global restriction set.
        $this->globalrestrictionset = $globalrestrictionset;

        $this->usedcomponents[] = 'totara_notification';
        $this->base = '{notification_delivery_log}';
        $this->joinlist = $this->define_joinlist();
        $this->columnoptions = $this->define_columnoptions();
        $this->filteroptions = $this->define_filteroptions();

        $this->add_notification_log();
        $this->add_notification_event_log();

        $this->sourcetitle   = $this->define_sourcetitle();
        $this->defaultcolumns = $this->define_defaultcolumns();
        $this->defaultfilters = $this->define_defaultfilters();
        $this->contentoptions = $this->define_contentoptions();
        $this->paramoptions = $this->define_paramoptions();

        $this->sourcesummary = get_string('source_summary', 'rb_source_notification_delivery_log');
        $this->sourcelabel = get_string('source_label', 'rb_source_notification_delivery_log');

        parent::__construct();
    }

    /**
     * @return string
     */
    protected function define_sourcetitle(): string {
        return get_string('source_title', 'rb_source_notification_delivery_log');
    }

    /**
     * @return rb_join[]
     */
    protected function define_joinlist(): array {
        return [
            new rb_join(
                'notification_log',
                'INNER',
                '{notification_log}',
                'base.notification_log_id = notification_log.id',
                REPORT_BUILDER_RELATION_MANY_TO_ONE
            ),
        ];
    }

    /**
     * @return rb_param_option[]
     */
    protected function define_paramoptions(): array {
        return [
            new rb_param_option(
                'user_id', // Parameter name.
                'recipient_user.id'  // Field.
            ),
            new rb_param_option(
                'context_id',
                'current_context.id',
                'current_context'
            ),
            new rb_param_option(
                'notification_log_id',
                'notification_log.id'
            ),
            new rb_param_option(
                'component',
                'notification_event_log.component'
            ),
            new rb_param_option(
                'area',
                'notification_event_log.area'
            ),
            new rb_param_option(
                'item_id',
                'notification_event_log.item_id'
            ),
        ];
    }

    /**
     * @return rb_column_option[]
     */
    protected function define_columnoptions(): array {
        return [
            new rb_column_option(
                'notification_delivery_log',
                'delivery_channel',
                get_string('delivery_channel', 'rb_source_notification_delivery_log'),
                'base.delivery_channel',
                [
                    'displayfunc' => 'notification_delivery_log_delivery_channel',
                    'extrafields' => ['address' => 'base.address']
                ]
            ),
            new rb_column_option(
                'notification_delivery_log',
                'has_error',
                get_string('has_error', 'rb_source_notification_delivery_log'),
                "base.has_error",
                [
                    'displayfunc' => 'yes_or_no'
                ]
            ),
            new rb_column_option(
                'notification_delivery_log',
                'delivery_status',
                get_string('delivery_status', 'rb_source_notification_delivery_log'),
                "base.has_error",
                [
                    'displayfunc' => 'delivery_log_status'
                ]
            )
        ];
    }

    /**
     * @return array[]
     */
    protected function define_defaultfilters(): array {
        return self::get_default_filters();
    }

    /**
     * @return rb_filter_option[]
     */
    protected function define_filteroptions(): array {
        return [
            new rb_filter_option(
                'notification_delivery_log',
                'delivery_channel',
                get_string('delivery_channel', 'rb_source_notification_delivery_log'),
                'select',
                [
                    'selectfunc' => 'delivery_channels'
                ]
            ),
            new rb_filter_option(
                'notification_delivery_log',
                'has_error',
                get_string('has_error', 'rb_source_notification_delivery_log'),
                'select',
                [
                    'selectfunc' => 'yesno_list'
                ]
            ),
        ];
    }

    /**
     * The default filters for this and embedded reports.
     *
     * @return array
     */
    public static function get_default_filters(): array {
        return [
            [
                'type' => 'notification_delivery_log',
                'value' => 'delivery_channel',
                'advanced' => 0,
            ],
            [
                'type' => 'recipient_user',
                'value' => 'fullname',
                'advanced' => 0,
            ],
            [
                'type' => 'notification_delivery_log',
                'value' => 'has_error',
                'advanced' => 0,
            ],
        ];
    }

    /**
     * Define the default columns for this report.
     *
     * @return array
     */
    protected function define_defaultcolumns(): array {
        return self::get_default_columns();
    }

    /**
     * Global report restrictions are implemented in this source.
     *
     * @return boolean
     */
    public function global_restrictions_supported(): bool {
        return true;
    }

    /**
     * The default columns for this and embedded reports.
     *
     * @return array
     */
    public static function get_default_columns(): array {
        // Be aware that if you change these, it'll affect the embedded report.
        return [
            [
                'type' => 'notification_event_log',
                'value' => 'event_time',
                'heading' => get_string('event_time', 'rb_source_notification_event_log'),
            ],
            [
                'type' => 'notification_log',
                'value' => 'preference_title',
                'heading' => get_string('preference_title', 'rb_source_notification_log'),
            ],
            [
                'type' => 'recipient_user',
                'value' => 'namelink',
                'heading' => get_string('recipient_user', 'rb_source_notification_log'),
            ],
            [
                'type' => 'notification_delivery_log',
                'value' => 'delivery_channel',
                'heading' => get_string('delivery_channel', 'rb_source_notification_delivery_log'),
            ],
            [
                'type' => 'notification_delivery_log',
                'value' => 'delivery_status',
                'heading' => get_string('delivery_status', 'rb_source_notification_delivery_log'),
            ],
        ];
    }

    /**
     * Define the available content options for this report.
     *
     * @return array
     */
    protected function define_contentoptions(): array {
        $contentoptions = [];

        // Add the manager/position/organisation content options.
        $this->add_basic_user_content_options($contentoptions, 'recipient_user');

        return $contentoptions;
    }

    /**
     * Inject column_test data into database.
     *
     * @codeCoverageIgnore
     * @param totara_reportbuilder_column_testcase $testcase
     */
    public function phpunit_column_test_add_data(totara_reportbuilder_column_testcase $testcase) {
        if (!PHPUNIT_TEST) {
            throw new coding_exception('phpunit_column_test_add_data() cannot be used outside of unit tests');
        }
        // Nothing to do by default.
        $generator = \core\testing\generator::instance();
        $user = $generator->create_user(['lastname' => 'User1 last name']);
        $context = context_system::instance();
        $extended_context = extended_context::make_with_context(
            $context,
            'totara_notification',
            'seminar',
            1
        );

        /** @var notification_event_log_entity $notification_event_log */
        $notification_event_log = notification_event_log::create(
            booking_confirmed::class,
            $extended_context,
            $user->id,
            [],
            '',
            '',
            '',
            [],
            false
        );

        $notification_event_log_id = $notification_event_log->id;

        // Create notification log entry
        /** @var notification_log_entity $notification_log */
        $notification_log = notification_log_model::create(
            $notification_event_log_id, 1, $user->id, time()
        );

        $notification_log_id = $notification_log->id;

        // Create notification delivery entry.
        model::create(
            $notification_log_id,
            'email',
            time(),
            'user1@example.com'
        );
    }

    /**
     * Gets all upload times for use in the filter
     *
     * @return array
     */
    public function rb_filter_delivery_channels(): array {
        global $DB;

        $out = array();
        $sql = "SELECT DISTINCT delivery_channel
                FROM {notification_delivery_log}
                ORDER BY delivery_channel DESC";

        $delivery_channels = $DB->get_records_sql($sql);
        foreach ($delivery_channels as $delivery_channel) {
            $out[$delivery_channel->delivery_channel] = channel_helper::get_label($delivery_channel->delivery_channel);
        }
        asort($out);

        return $out;
    }
}