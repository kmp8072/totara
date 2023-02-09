/**
 * This file is part of Totara Enterprise Extensions.
 *
 * Copyright (C) 2022 onwards Totara Learning Solutions LTD
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
 * @author Simon Chester <simon.chester@totaralearning.com>
 * @module editor_weka
 */

import WekaValue from '../WekaValue';
import * as unknownNodeRewritingFixture from './test_util/unknown_node_rewriting';

describe('WekaValue', () => {
  it('reverses unknown node transform', () => {
    const value = WekaValue.fromState({
      toJSON() {
        return { doc: unknownNodeRewritingFixture.rewrittenDoc };
      },
    });

    expect(value.getDoc()).toEqual(unknownNodeRewritingFixture.originalDoc);
  });
});
