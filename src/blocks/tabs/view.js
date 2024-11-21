/**
 * WordPress dependencies
 */
import { store, getContext } from "@wordpress/interactivity";

store("tabs", {
  actions: {
    *open() {
      const context = getContext();

      context.tabs.forEach((singleTab) => (singleTab.isActive = false));
      context.tab.isActive = true;

      const url = new URL(window.location);
      url.searchParams.set("tab", context.tab.id);

      const { actions } = yield import("@wordpress/interactivity-router");

      yield actions.navigate(`${window.location.pathname}${url.search}`);
    },
  },
});
