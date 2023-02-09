<?php
/**
 * This file is part of Totara Learn
 *
 * Copyright (C) 2021 onwards Totara Learning Solutions LTD
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
 * @author  Kian Nguyen <kian.nguyen@totaralearning.com>
 * @package totara_notification
 */
namespace totara_notification\json_editor\node;

use coding_exception;
use core\json_editor\formatter\formatter;
use core\json_editor\helper\node_helper;
use core\json_editor\node\abstraction\inline_node;
use core\json_editor\node\node;
use html_writer;
use totara_notification\placeholder\key_helper;

/**
 * The full type name of this node will be "totara_notification_placeholder"
 */
class placeholder extends node implements inline_node {
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $label;

    /**
     * Returns a simple <span/> tag with the placeholder value as display.
     *
     * @param formatter $formatter
     * @return string
     */
    public function to_html(formatter $formatter): string {
        // Returning a simple <span/> tag
        $key = key_helper::strip_invalid_characters_from_key($this->key);

        // Note that the html_writer itself is already calling to {@see s()} when rendering
        // the attributes to the tag.
        return html_writer::span(
            "[{$key}]",
            '',
            [
                'data-key' => $key,
                'data-label' => $this->label,
            ]
        );
    }

    /**
     * @param array $node
     * @return node
     */
    public static function from_node(array $node): node {
        /** @var placeholder $placeholder */
        $placeholder = parent::from_node($node);

        // These coding_exception below should never be happening because from the process of
        // constructing node, all of the clean param and validation functions have already been
        // called beforehand. However this is to make sure that we fail the process if some one
        // is calling this function directly without providing the right structure.
        if (!isset($node['attrs'])) {
            throw new coding_exception("The placeholder node does not have 'attrs' in its structure");
        }

        $attrs = $node['attrs'];
        if (!isset($attrs['key']) || !isset($attrs['label'])) {
            throw new coding_exception("Missing key 'key'/'label' inside 'attrs'");
        }

        // Making sure that the bracket does not get to this node attributes.
        $placeholder->key = key_helper::remove_bracket($attrs['key']);
        $placeholder->label = $attrs['label'];

        return $placeholder;
    }

    /**
     * @param array $raw_node
     * @return array|null
     */
    public static function clean_raw_node(array $raw_node): ?array {
        $result = parent::clean_raw_node($raw_node); // TODO: Change the autogenerated stub
        if (null === $result) {
            return null;
        }

        // At this point we should be certain that attribute 'key' and 'label' should
        // be existing within. However, if this function is called separately then it
        // will fail to process.
        $attrs = $result['attrs'];
        $attrs['label'] = clean_param($attrs['label'], PARAM_TEXT);

        // For the group key, we will try to separate the text and clean it separately.
        // The concatenate them back together.
        // Note: we should remove the bracket when we store the document.
        $grouped_key = key_helper::remove_bracket($attrs['key']);

        [$group, $placeholder_key] = key_helper::normalize_grouped_key($grouped_key);
        $attrs['key'] = key_helper::get_group_key(
            clean_param($group, PARAM_ALPHANUMEXT),
            clean_param($placeholder_key, PARAM_ALPHANUMEXT)
        );

        // Assign back the clean parameters.
        $result['attrs'] = $attrs;
        return $result;
    }

    /**
     * For text rendering, we are just rendering the placeholder keys only.
     *
     *
     * @param formatter $formatter
     * @return string
     */
    public function to_text(formatter $formatter): string {
        return "[{$this->key}]";
    }

    /**
     * @return string
     */
    protected static function do_get_type(): string {
        return 'placeholder';
    }

    /**
     * @param array $raw_node
     * @return bool
     */
    public static function validate_schema(array $raw_node): bool {
        if (!array_key_exists('attrs', $raw_node) || empty($raw_node['attrs'])) {
            return false;
        }

        if (!node_helper::check_keys_match_against_data($raw_node, ['type', 'attrs'])) {
            return false;
        }

        $attrs = $raw_node['attrs'];
        if (!array_key_exists('key', $attrs) || !array_key_exists('label', $attrs)) {
            return false;
        } else if (!node_helper::check_keys_match_against_data($attrs, ['key', 'label'])) {
            return false;
        }

        $key = $attrs['key'];
        if (!key_helper::is_valid_grouped_key($key)) {
            $type = $raw_node['type'] ?? static::get_type();

            debugging("Invalid group key '{$key}' in json node '{$type}'", DEBUG_DEVELOPER);
            return false;
        }

        $input_keys = array_keys($attrs);
        return node_helper::check_keys_match($input_keys, ['key', 'label']);
    }

    /**
     * @param string        $grouped_key
     * @param string|null   $label
     * @return array
     */
    public static function create_node_from_key_and_label(string $grouped_key, ?string $label = null): array {
        return [
            'type' => static::get_type(),
            'attrs' => [
                'key' => $grouped_key,
                'label' => $label ?? '',
            ],
        ];
    }
}
