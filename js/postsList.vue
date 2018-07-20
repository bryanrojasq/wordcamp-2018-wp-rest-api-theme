<template>
    <div class="posts">
        <div v-if="loading" class="loading-container">
          <p class="loading-text">Loading...</p>
        </div>
        <h1 class="content-subhead">Recent Posts</h1>        
        <section class="post" v-for="post in posts" v-bind:key="post.id">
            <header class="post-header">
                <router-link :to="{ name: 'singlePost', params: { postName: post.slug } }" class="postItem__link">
                    <h2 class="post-title">{{ post.title.rendered }}</h2>
                </router-link>
                <p class="post-meta">
                    <span class="post-author">{{post._embedded.author[0].name}}</span> under                            
                    <span v-for="category in post.categories_extension"  v-bind:key="category.term_id" class="post-category post-category-pure">{{category.name}}</span>
                </p>
            </header>
            <div class="post-description" v-html="post.excerpt.rendered"></div>
        </section>
        <div class="pure-menu pure-menu-horizontal pure-menu-center">
            <ul class="pure-menu-list">
                <li class="pure-menu-item pure-menu-disabled">Page {{currentPage}} of {{totalPages}}</li>
                <li class="pure-menu-item" v-bind:class="{ 'pure-button-disabled': !prevPage || loading}"><a v-on:click="getPosts(prevPage)" class="pure-button pure-button-primary">Prev</a></li>
                <li class="pure-menu-item" v-bind:class="{ 'pure-button-disabled': !nextPage || loading}"><a v-on:click="getPosts(nextPage)" class="pure-button pure-button-primary">Next</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
module.exports = {
  name: "postsList",
  data() {
    return {
      loading: false,
      posts: "",
      currentPage: "",
      totalPages: 1,
      prevPage: "",
      nextPage: ""
    };
  },
  mounted: function() {
    this.getPosts();
  },
  methods: {
    getPosts: function(pageNum) {
      this.currentPage = typeof pageNum !== "undefined" ? pageNum : 1;
      this.loading = true;
      this.$http
        .get(wpRoutes.api + "posts?_embed&per_page=6&page=" + this.currentPage)
        .then(
          response => {
            // get response data
            this.paginate(response);
            this.loading = false;
          },
          err => {
            // error callback
            // log the way you need
          }
        );
    },
    paginate: function(res) {
      //all data passed to template
      this.posts = res.data;

      //get total pages to limit pagination
      this.totalPages = parseInt(res.headers.get("X-WP-TotalPages"), 10);

      //check min page
      if (this.currentPage > 1) {
        this.prevPage = this.currentPage - 1;
      } else {
        this.prevPage = null;
      }

      //check max page
      if (this.currentPage < this.totalPages) {
        this.nextPage = this.currentPage + 1;
      } else {
        this.nextPage = null;
      }
    }
  }
};
</script>

<style>
.posts {
  min-height: 600px;
}
</style>





