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
 * @package totara_tenant
 */

require(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/totara/reportbuilder/lib.php');

$sid = optional_param('sid', 0, PARAM_INT);
$format = optional_param('format', '', PARAM_ALPHANUMEXT);
$debug = optional_param('debug', 0, PARAM_INT);

$syscontext = context_system::instance();
admin_externalpage_setup('tenantsmanage');

$config = (new rb_config())->set_sid($sid);
$report = reportbuilder::create_embedded('tenants', $config);

$PAGE->set_button($report->edit_button() . $PAGE->button);

$addbutton = '';
if (!empty($CFG->tenantsenabled) and has_capability('totara/tenant:config', $syscontext)) {
    $addbutton = $OUTPUT->single_button(new moodle_url('/totara/tenant/tenant_create.php'), get_string('tenantcreate', 'totara_tenant'), 'get');
}

/** @var totara_reportbuilder_renderer|core_renderer $output */
$output = $PAGE->get_renderer('totara_reportbuilder');

if (!empty($format)) {
    $report->export_data($format);
    die;
}

$report->include_js();

echo $output->header();
list($reporthtml, $debughtml) = $output->report_html($report, $debug);
echo $debughtml;

echo $output->heading(get_string('sourcetitle', 'rb_source_tenants') . ': ' . $output->result_count_info($report));

// Print saved search options and filters.
$report->display_search();
$report->display_sidebar_search();

echo $addbutton;
echo $reporthtml;

$output->export_select($report, $sid);

echo $output->footer();
