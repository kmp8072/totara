/**
 * This file is part of Totara Enterprise Extensions.
 *
 * Copyright (C) 2020 onwards Totara Learning Solutions LTD
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
 * @author Kian Nguyen <kian.nguyen@totaralearning.com>
 * @module totara_engage
 */

import EngageSidePanel from 'totara_engage/components/sidepanel/EngageSidePanel';
import { shallowMount } from '@vue/test-utils';

describe('Engage EngageSidePanel', () => {
  let wrapper = null;

  beforeAll(() => {
    wrapper = shallowMount(EngageSidePanel, {
      propsData: {
        userEmail: 'admin@example.com',
        userId: 42,
        userFullName: 'admin user',
        userProfileImageUrl: 'http://example.com',
      },

      mocks: {
        $str(x, y) {
          return `${x}-${y}`;
        },
      },
    });
  });

  it('Checks snapshot', () => {
    expect(wrapper.element).toMatchSnapshot();
  });
});
