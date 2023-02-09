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
 * @author Kian Nguyen <kian.nguyen@totaralearning.com>
 * @package totara_core
 */
namespace totara_core\content\processor;

use core\json_editor\document;
use totara_core\content\content;
use totara_core\content\processor;
use core\json_editor\node\hashtag as hashtag_node;
use totara_core\hashtag\hashtag;

/**
 * For adding hashtag from the editor content.
 */
final class hashtag_processor extends processor {
    /**
     * @param content $content
     * @return void
     */
    public function process_format_moodle(content $content): void {
        $this->process_format_text($content);
    }

    /**
     * @param content $content
     * @return void
     */
    public function process_format_html(content $content): void {
        $this->process_format_text($content);
    }

    /**
     * @param content $content
     * @return void
     */
    public function process_format_text(content $content): void {
        // todo: me
    }

    /**
     * @param content $content
     * @return void
     */
    public function process_format_json_editor(content $content): void {
        $text_content = $content->get_content();
        if (empty($text_content)) {
            return;
        }

        $document = document::create($text_content);

        /** @var hashtag_node[] $nodes */
        $nodes = $document->find_nodes(hashtag_node::get_type());

        foreach ($nodes as $node) {
            hashtag::create($node->get_text());
        }
    }
}