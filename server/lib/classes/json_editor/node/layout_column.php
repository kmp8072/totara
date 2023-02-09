<?php
/**
 * This file is part of Totara TXP
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
 * @author Simon Chester <simon.chester@totaralearning.com>
 * @package core
 */
namespace core\json_editor\node;

use core\json_editor\formatter\formatter;
use core\json_editor\helper\node_helper;
use core\json_editor\schema;
use core\json_editor\node\abstraction\block_node;
use html_writer;

/**
 * Node for layout_column.
 */
final class layout_column extends node implements block_node {
    /**
     * @var node[]
     */
    private $contents;

    /**
     * @var string
     */
    private $layout_type;

    /**
     * @param array $node
     * @return node
     */
    public static function from_node(array $node): node {
        /** @var layout_column $instance */
        $instance = parent::from_node($node);
        $instance->contents = [];

        if (isset($node['content'])) {
            $instance->contents = $node['content'];
        }

        $instance->layout_type = $node['attrs']['type'] ?? null;

        return $instance;
    }

    /**
     * @param array $raw_node
     * @return bool
     */
    public static function validate_schema(array $raw_node): bool {
        if (isset($raw_node['content']) && !is_array($raw_node['content'])) {
            return false;
        }

        if (!empty($raw_node['content'])) {
            $contents = $raw_node['content'];
            $schema = schema::instance();

            foreach ($contents as $raw_node_content) {
                if (!isset($raw_node_content['type'])) {
                    // Invalid node content that is not an array.
                    return false;
                }

                $node_type = $raw_node_content['type'];
                $node_class = $schema->get_node_classname($node_type);

                if ($node_class === null) {
                    // Skip the invalid node for now.
                    debugging("Class for node type '{$node_type}' does not exist", DEBUG_DEVELOPER);
                    continue;
                }

                if (!is_subclass_of($node_class, block_node::class)) {
                    // Invalid node being placed.
                    return false;
                }

                $inner_result = call_user_func([$node_class, 'validate_schema'], $raw_node_content);
                if (!$inner_result) {
                    return false;
                }
            }
        }

        $input_keys = array_keys($raw_node);
        return node_helper::check_keys_match($input_keys, ['type'], ['content', 'attrs']);
    }

    /**
     * @param array $raw_node
     * @return array|null
     */
    public static function clean_raw_node(array $raw_node): ?array {
        $cleaned_raw_node = parent::clean_raw_node($raw_node);
        if ($cleaned_raw_node === null) {
            return null;
        }

        $content = static::clean_raw_node_content($cleaned_raw_node['content'] ?? []);
        if ($content === null) {
            return null;
        }
        $cleaned_raw_node['content'] = $content;

        return $cleaned_raw_node;
    }

    /**
     * @return string
     */
    protected static function do_get_type(): string {
        return 'layout_column';
    }

    /**
     * @param formatter $formatter
     * @return string
     */
    public function to_html(formatter $formatter): string {
        $str = $formatter->print_nodes($this->contents, formatter::HTML);

        $style_class = 'jsoneditor-layout-column';
        if ($this->layout_type === 'sidebar') {
            $style_class .= ' jsoneditor-layout-column--sidebar';
        }

        return html_writer::div($str, $style_class);
    }

    /**
     * @param formatter $formatter
     * @return string
     */
    public function to_text(formatter $formatter): string {
        return $formatter->print_nodes($this->contents, formatter::TEXT);
    }
}