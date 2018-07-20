<template>
    <section class="post">
        <div v-if="loading" class="loading-container">
            <p class="loading-text">Loading...</p>
        </div>
        <div class="post-content" v-if="!loading">
            <header class="post-header">
                <h2 class="post-title">{{ post.title.rendered }}</h2>
            </header>
            <div class="post-description" v-html="post.content.rendered"></div>
        </div>
    </section>
</template>

<script>
module.exports = {
  name: "singlePage",
  data() {
    return {
      loading: false,
      post: ""
    };
  },
  created: function() {
    this.getSinglePage();
  },
  watch: {
    '$route' (to, from) {
        this.getSinglePage();
    }
  },
  methods: {
    getSinglePage: function() {
      this.loading = true;
      const pageId = this.$route.params.pageId;
      this.$http.get(wpRoutes.api + "pages/" + pageId).then(
        response => {
          this.post = response.data;
          this.loading = false;
        },
        err => {
          //err
        }
      );
    }
  }
};
</script>

<style>

.post-description img {
    max-width: 100%;
}

</style>


