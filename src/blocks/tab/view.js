/**
 * WordPress dependencies
 */
import { getContext, store } from "@wordpress/interactivity";

store("tabs", {
  state: {
    isInternalTabActive() {
      const {activeTabId, id} = getContext();

      return activeTabId === id;
    },
  }
});
