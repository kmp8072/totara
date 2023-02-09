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
 * @author Simon Chester <simon.chester@totaralearning.com>
 * @module mod_approval
 */

import { createMachine } from 'tui_xstate/xstate';
import * as selectors from './selectors';
import * as actions from './actions';
import makeState from './state';

export default function cloneMachine({ workflow, contextId } = {}) {
  const options = {
    selectors,
    actions,
  };

  const state = makeState({ workflow, contextId });

  return createMachine(state, options);
}