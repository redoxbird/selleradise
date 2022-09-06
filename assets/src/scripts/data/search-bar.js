import { searchService } from "../machines/search";
import { debounce, get, isEmpty } from "lodash-es";
import { device } from "../helpers";

export default (props = {}) => ({
  state: "idle",
  hidden: false,
  keyword: "",
  products: [],
  terms: [],
  type: props?.type || "native",
  debouncedGetResults: () => {},

  init() {
    searchService.onTransition((state) => {
      this.state = state.value;
    });

    this.debouncedGetResults = debounce(this.getResults, 500);
  },

  startSearch() {
    searchService.send("START");
  },

  stopSearch() {
    searchService.send("STOP");
  },

  handelInputKeyDown(e) {
    switch (e.key) {
      case "Enter":
        if (this.keyword.length <= 2) {
          e.preventDefault();
        } else {
          this.$refs.searchForm.submit();
        }
        break;
      case "ArrowDown":
        e.preventDefault();
        e.stopPropagation();
        this.$focus.within(this.$refs.results).first();
        break;

      default:
        break;
    }
  },

  handleInputChange(e) {
    this.keyword = e.target.value;

    if (this.keyword.length <= 2) {
      return;
    }

    this.debouncedGetResults();
  },

  handleSubmitBlur() {
    ["not_found", "initiated"].includes(this.state) &&
      searchService.send("STOP");
  },

  clear() {
    this.keyword = "";
    this.$refs.searchForm.focus();
  },

  send(event) {
    searchService.send(event);
  },

  stop() {
    if (this.show()) {
      searchService.send("STOP");
    }
  },

  start() {
    searchService.send("START");
  },

  show() {
    return !["idle"].includes(this.state);
  },

  isModal() {
    return (
      device("mobileAndTablet") ||
      ["common", "minimal", "centered", "robust-centered"].includes(
        props.headerType
      )
    );
  },

  async getResults() {
    if (isEmpty(this.keyword)) {
      return;
    }

    searchService.send("SEARCH");
    const params = {};
    const url = {};

    params["native"] = new URLSearchParams({
      action: "selleradise_search_terms",
      keyword: this.keyword,
      _wpnonce: selleradiseData["_wpnonce"],
    });

    params["fibosearch"] = new URLSearchParams({
      s: this.keyword,
    });

    url["native"] = `${selleradiseData.ajaxURL}?${params[
      this.type
    ].toString()}`;

    url["fibosearch"] = `${
      selleradiseData.wcAjaxURL
    }=dgwt_wcas_ajax_search&${params[this.type].toString()}`;

    const response = await fetch(url[this.type], {
      method: "get",
    });

    if (!response.ok) {
      searchService.send("FAILED");
    }

    const result = await response.json();

    if (this.type === "native") {
      this.products = result?.products;
      this.terms = result?.terms;
    } else if (this.type === "fibosearch") {
      this.products = result?.suggestions?.filter(
        (suggestion) => suggestion.type === "product"
      );
      this.terms = result?.suggestions?.filter((suggestion) =>
        suggestion.hasOwnProperty("taxonomy")
      );
    }

    if (this.products && this.products.length > 0) {
      searchService.send("FOUND");
    } else {
      searchService.send("NOT_FOUND");
    }
  },

  getName(item, of) {
    const key = {
      product: {
        native: "post_title",
        fibosearch: "value",
      },
      term: {
        native: "name",
        fibosearch: "value",
      },
    };

    return get(item, key[of][this.type]);
  },

  getLink(result, of) {
    const key = {
      product: {
        native: "guid",
        fibosearch: "url",
      },
      term: {
        native: "link",
        fibosearch: "url",
      },
    };

    return get(result, key[of][this.type]);
  },

  getPrice(result) {
    const key = {
      native: "price",
    };

    return get(result, key[this.type]);
  },

  getImage(result) {
    const key = {
      native: "image",
      fibosearch: "thumb_html",
    };

    return get(result, key[this.type]);
  },
});
