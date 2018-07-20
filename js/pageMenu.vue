<template>
  <div class="pure-menu pure-menu-horizontal" v-if="!loading">
        <a href="#/" class="pure-menu-heading pure-menu-link">Home</a>
        <ul class="pure-menu-list">
            <li class="pure-menu-item" v-for="page in pages" v-bind:key="page.id">
                <router-link :to="{ name: 'singlePage', params: { pageId: page.id } }" class="pure-menu-link">
                    {{ page.title.rendered}}
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
module.exports = {
  name: "pageMenu",
  data() {
    return {
      loading: false,
      pages: ""
    };
  },
  mounted: function() {
    this.getPages();
  },
  methods: {
    getPages: function() {
      this.loading = true;
      this.$http.get(wpRoutes.api + "pages").then(
        response => {
          // get response data
          this.pages = response.data;
          this.loading = false;
        },
        err => {
          // error callback
          // log the way you need
        }
      );
    }
  }
};
</script>