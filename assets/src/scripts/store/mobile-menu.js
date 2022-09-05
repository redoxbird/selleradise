import { mobileMenuService } from "../machines/mobile-menu";

export default {
  state: "",
  activeSidebar: "menu",

  async init() {
    mobileMenuService.onTransition((state) => {
      this.state = state.value;
    });

    this.enableTriggers();
  },

  isOpen() {
    return ["visible", "changing"].includes(this.state);
  },

  open(active) {
    this.activeSidebar = active;
    mobileMenuService.send("OPEN");
  },

  close() {
    mobileMenuService.send("CLOSE");
  },

  enableTriggers() {
    const links = document.querySelectorAll(
      'a[href^="#selleradise_sidebar__"]'
    );

    if (links.length < 1) {
      return;
    }

    for (const index in links) {
      if (links.hasOwnProperty.call(links, index)) {
        const link = links[index];
        const type = link.href.split("__")[1];

        if (!type) {
          continue;
        }

        link.addEventListener("click", (e) => {
          e.preventDefault();
          this.open(type);
        });
      }
    }
  },
};
