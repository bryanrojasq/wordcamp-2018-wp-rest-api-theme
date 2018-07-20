"use strict";
var postsList = httpVueLoader(wpRoutes.themeUri + "/js/postsList.vue");
var singlePost = httpVueLoader(wpRoutes.themeUri + "/js/singlePost.vue");
var pageMenu = httpVueLoader(wpRoutes.themeUri + "/js/pageMenu.vue");
var singlePage = httpVueLoader(wpRoutes.themeUri + "/js/singlePage.vue");

const router = new VueRouter({
  routes: [
    {
      path: "/",
      name: "home",
      component: postsList
    },
    {
      path: "/post/:postName",
      name: "singlePost",
      component: singlePost
    },
    ,
    {
      path: "/page/:pageId",
      name: "singlePage",
      component: singlePage
    }
  ]
});

const app = new Vue({
  router,
  components: {
    'page-menu' : pageMenu
  }
}).$mount("#app");
