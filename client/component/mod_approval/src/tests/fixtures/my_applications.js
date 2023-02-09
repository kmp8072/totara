/**
 * This file is part of Totara Enterprise Extensions.
 *
 * Copyright (C) 2021 onwards Totara Learning Solutions LTD
 *
 * Totara Enterprise Extensions is provided only to Totara
 * Learning Solutions LTD's customers and partners, pursuant to
 * the terms and conditions of a separate agreement with Totara
 * Learning Solutions LTD or its affiliate.
 *
 * If you do not have an agreement with Totara Learning Solutions
 * LTD, you may not access, use, modify, or distribute this software.
 * Please contact [licensing@totaralearning.com] for more information.
 *
 * @author Simon Tegg <simon.teggfe@totaralearning.com>
 * @module mod_approval
 */
export default {
  mod_approval_my_applications: {
    items: [
      {
        id: 3,
        workflow_type: 'SF-182',
        created: '2021-03-12T00:56:17.899Z',
        submitted: null,
        overall_progress: 'IN_PROGRESS',
        your_progress: 'PENDING',
        submitted_by: {
          id: 2,
          fullname: 'Florence N',
          profileUrl: 'url',
        },
      },
      {
        id: 5,
        workflow_type: 'SF-182',
        created: '2021-03-12T00:56:17.899Z',
        submitted: null,
        overall_progress: 'APPROVED',
        your_progress: 'PENDING',
        submitted_by: {
          id: 2,
          fullname: 'Florence N',
          profileUrl: 'url',
        },
      },
      {
        id: 7,
        workflow_type: 'SF-182',
        created: '2021-03-12T00:56:17.899Z',
        submitted: null,
        overall_progress: 'IN_PROGRESS',
        your_progress: 'PENDING',
        submitted_by: {
          id: 2,
          fullname: 'Florence N',
          profileUrl: 'url',
        },
      },
    ],
    total: 234,
    next_cursor: {},
  },
};
