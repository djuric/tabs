/**
 * WordPress dependencies
 */
import { store, getContext } from "@wordpress/interactivity";

store("tabs", {
  actions: {
    *open(e) {
      const context = getContext();

      context.tabs.forEach((singleTab) => singleTab.isActive = singleTab.id === e.target.dataset.id);
      context.activeTabId = e.target.dataset.id;

      const url = new URL(window.location);
      url.searchParams.set("tab", e.target.dataset.id);

      const { actions } = yield import("@wordpress/interactivity-router");

      yield actions.navigate(`${window.location.pathname}${url.search}`);
    },
  },
});
