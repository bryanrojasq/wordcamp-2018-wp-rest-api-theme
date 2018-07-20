<template>
    <section class="post post-single">
        <div v-if="loading" class="loading-container">
            <p class="loading-text">Loading...</p>
        </div>
        <div class="post-content" v-if="!loading">
            <header class="post-header" v-bind:style="{ 'background-image': 'url(' + post.featured_image + ')' }">
                <div class="post-header-meta">
                    <h2 class="post-title">{{ post.title.rendered }}</h2>
                    <p class="post-meta">
                        <span class="post-author">{{post._embedded.author[0].name}}</span> under                            
                        <span v-for="category in post.categories_extension"  v-bind:key="category.term_id" class="post-category">{{category.name}}</span>
                        <span v-if="post.time" class="post-category">Extra Time: {{post.time}}</span>
                    </p>
                </div>
            </header>
            <div class="post-description" v-html="post.content.rendered"></div>
        </div>
    </section>
</template>

<script>
module.exports = {
  name: "singlePost",
  data() {
    return {
      loading: false,
      post: ""
    };
  },
  created: function() {
    this.getSinglePost();
  },
  methods: {
    getSinglePost: function() {
      this.loading = true;
      const postName = this.$route.params.postName;
      this.$http.get(wpRoutes.api + "posts/?_embed&slug=" + postName).then(
        response => {
          this.post = response.data[0];
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
.post-single .post-header {
  background: no-repeat;
  background-size: cover;
  background-position: center;
  min-height: 200px;
  position: relative;
}

.post-single .post-title {
    color: #fff;
    text-shadow: 1px 1px rgba(0,0,0,.8);
}

.post-single .post-header .post-header-meta {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  margin-left: 30px;
}

.post-description img {
  max-width: 100%;
}
</style>


