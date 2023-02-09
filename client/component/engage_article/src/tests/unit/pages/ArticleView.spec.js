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
 * @module engage_article
 */

import ArticleView from 'engage_article/pages/ArticleView';
import { mount } from '@vue/test-utils';

jest.mock('tui/apollo_client', () => null);

describe('Engage ArticleView', function() {
  let wrapper = null;

  beforeAll(function() {
    wrapper = mount(ArticleView, {
      mocks: {
        $str(identifier, component) {
          return `${identifier}, ${component}`;
        },
        $apollo: {},
      },
      propsData: {
        resourceId: 1,
      },
    });
  });

  it('Checks snapshot', function() {
    expect(wrapper.html()).toMatchSnapshot();
  });
});
