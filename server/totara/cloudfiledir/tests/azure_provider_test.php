<?php
/*
 * This file is part of Totara Learn
 *
 * Copyright (C) 2019 onwards Totara Learning Solutions LTD
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
 * @author Petr Skoda <petr.skoda@totaralearning.com>
 * @package totara_cloudfiledir
 */

use totara_cloudfiledir\local\provider\azure;

require_once(__DIR__ . '/provider_test.php');

defined('MOODLE_INTERNAL') || die();

/**
 * Azure Blob storage provider test.
 */
final class totara_cloudfiledir_azure_provider_testcase extends totara_cloudfiledir_provider_testcase {
    protected function get_provider() {
        if (!file_exists(__DIR__ . '/../../../../libraries/optional/autoload.php')) {
            $this->markTestSkipped('Missing cloud client libraries');
        }
        $options = static::get_provider_options();
        $bucket = self::get_provider_bucket();
        if (!$options || !$bucket) {
            $this->markTestSkipped('Missing Azure test configuration constants');
        }
        return new azure($options, 'test', $bucket, '');
    }

    /**
     * Returns Amazon AZURE options for testing.
     * @return array|null
     */
    public static function get_provider_options(): ?array {
        if (!defined('TEST_CLOUDFILEDIR_AZURE_OPTIONS')) {
            return null;
        }
        return json_decode(TEST_CLOUDFILEDIR_AZURE_OPTIONS, true);
    }

    /**
     * Returns Amazon AZURE options for testing.
     * @return string|null
     */
    public static function get_provider_bucket(): ?string {
        if (defined('TEST_CLOUDFILEDIR_AZURE_BUCKET')) {
            return TEST_CLOUDFILEDIR_AZURE_BUCKET;
        } else {
            return null;
        }
    }
}
