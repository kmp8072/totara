<?php
/**
 * This file is part of Totara Core
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
 * @package contentmarketplace_linkedin
 */
namespace contentmarketplace_linkedin\api\v2\service\learning_classification;

use contentmarketplace_linkedin\api\response\result;
use contentmarketplace_linkedin\api\v2\service\learning_classification\query\query;
use contentmarketplace_linkedin\api\v2\service\learning_classification\response\collection;
use contentmarketplace_linkedin\api\v2\service\service as service_interface;
use moodle_url;
use totara_core\http\response;

class service implements service_interface {
    /**
     * @var query
     */
    private $query;

    /**
     * service constructor.
     * @param query $query
     */
    public function __construct(query $query) {
        $this->query = $query;
    }

    /**
     * @param moodle_url $endpoint_url
     * @return moodle_url
     */
    public function apply_to_url(moodle_url $endpoint_url): moodle_url {
        $cloned_url = new moodle_url($endpoint_url);
        $cloned_url->remove_all_params();

        $endpoint = sprintf(
            '%s/learningClassifications',
            $cloned_url->out(false)
        );

        return $this->query->build_url(new moodle_url($endpoint));
    }

    /**
     * @param response $response
     * @return result
     */
    public function wrap_response(response $response): result {
        $json_data = $response->get_body_as_json();
        return collection::create($json_data);
    }
}