<?php
/**
 * This file is part of Totara Learn
 *
 * Copyright (C) 2020 onwards Totara Learning Solutions LTD
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
 * @author Johannes Cilliers <johannes.cilliers@totaralearning.com>
 * @package core
 */

namespace core\theme\file;

use context;
use core\files\type\file_type;
use core\files\type\web_image;
use core\theme\settings;
use theme_config;

/**
 * Class logo_image
 *
 * This file handler is used to get a different version of a file belonging to
 * the theme and within specific context that we have access to, otherwise the
 * default file will be be fetched.
 *
 * This file handler is also used by theme settings to generate a dynamic list
 * of files that can be customised by a user.
 * @see settings
 * @see theme_file
 *
 * @package core\theme\file
 */
class logo_image extends theme_file {

    /**
     * logo_image constructor.
     *
     * @param theme_config|null $theme_config
     */
    public function __construct(?theme_config $theme_config = null) {
        parent::__construct($theme_config);
        $this->type = new web_image();
    }

    /**
     * @inheritDoc
     */
    public static function get_id(): string {
        return 'totara_core/logo';
    }

    /**
     * @inheritDoc
     */
    public function get_component(): string {
        return 'totara_core';
    }

    /**
     * @inheritDoc
     */
    public function get_area(): string {
        return 'logo';
    }

    /**
     * @inheritDoc
     */
    public function get_ui_key(): string {
        return 'sitelogo';
    }

    /**
     * @inheritDoc
     */
    public function get_ui_category(): string {
        return 'brand';
    }

    /**
     * @inheritDoc
     */
    public function get_type(): file_type {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function get_default_categories(): array {
        return [
            [
                'name' => 'brand',
                'properties' => [
                    [
                        'name' => 'formbrand_field_logoalttext',
                        'type' => 'text',
                        'value' => get_string('totaralogo', 'totara_core'),
                    ]
                ]
            ]
        ];
    }

    /**
     * Get custom alternative text.
     *
     * @return string
     */
    public function get_alt_text(): string {
        $settings = $this->get_theme_settings_instance();
        $property = $settings->get_property('brand', 'formbrand_field_logoalttext');
        if (!empty($property)) {
            return $property['value'];
        }
        return get_string('totaralogo', 'totara_core');
    }

}