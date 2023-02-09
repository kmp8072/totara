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
 * @author Arshad Anwer <arshad.anwer@totaralearning.com>
 * @module weka_notification_placeholder
 */

import Placeholder from 'weka_notification_placeholder/components/nodes/Placeholder.vue';
import { shallowMount } from '@vue/test-utils';

describe('weka_notification Placeholder.vue', function() {
  let wrapper;

  beforeAll(() => {
    wrapper = shallowMount(Placeholder, {
      mocks: {
        $url(url, params) {
          return `${url}?${params.toString()}`;
        },

        $str(id, component) {
          return `${id}-${component}`;
        },
      },

      propsData: {
        nodeInfo: {
          node: {
            attrs: {
              key: 21,
              label: 'Basic user',
            },
          },
        },
      },
    });
  });

  it('matches snapshot', () => {
    expect(wrapper.element).toMatchSnapshot();
  });
});
