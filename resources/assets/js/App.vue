<style lang="sass">
    @import '../sass/app.sass';
</style>
<template>
    <div id="app">

        <nav class="nav">
          <div class="nav-left">
            <a class="nav-item">
              <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma logo">
            </a>
          </div>
        </nav>

        <article class="media">
          <div class="media-left tree-box">
              <app-categories  :url="urlcategories"></app-categories>
          </div>
          <div class="media-content">
            <div class="content">
              <app-goods></app-goods>
            </div>
          </div>
        </article>

    </div>
</template>

<script>
  import Goods from './components/Goods.vue';
  import Categories from './components/Categories.vue';

export default {
  name: 'app',
  data : function() {
    return {
      urlcategories: this.$root.prefix_url + '/categories'
    }
  },
  components: {
               appGoods: Goods,
               appCategories: Categories,
  }
}
</script>
