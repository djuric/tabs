/**
 * WordPress dependencies
 */
import { store, getContext } from "@wordpress/interactivity";

store("tabs", {
  state: {
    get isTabActive() {
      const { activeTabId, tab } = getContext();

      return activeTabId === tab.id;
    },
  },
  actions: {
    *open() {
      const context = getContext();
      
      context.tabs.forEach((singleTab) => (singleTab.isActive = false));
      context.tab.isActive = true;
      context.activeTabId = context.tab.id;

      const url = new URL(window.location);
      url.searchParams.set("tab", context.tab.id);

      const { actions } = yield import("@wordpress/interactivity-router");

      yield actions.navigate(`${window.location.pathname}${url.search}`);
    },
  },
});
