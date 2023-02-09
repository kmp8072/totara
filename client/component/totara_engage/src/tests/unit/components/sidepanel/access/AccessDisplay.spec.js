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
 * @author Alvin Smith <alvin.smith@totaralearning.com>
 * @module totara_engage
 */

import AccessDisplay from 'totara_engage/components/sidepanel/access/AccessDisplay';
import { shallowMount } from '@vue/test-utils';
import { AccessManager } from 'totara_engage/index';

describe('Engage AccessDisplay', () => {
  let wrapper;

  beforeAll(() => {
    wrapper = shallowMount(AccessDisplay, {
      mocks: {
        $str(x, y) {
          return `${x}-${y}`;
        },
      },

      propsData: {
        accessValue: AccessManager.PUBLIC,
      },
    });
  });

  it('Checks snapshot', () => {
    expect(wrapper.element).toMatchSnapshot();
  });
});
