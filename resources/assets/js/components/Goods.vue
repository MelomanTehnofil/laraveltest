<template>
    <div id="good_list" class="parent">
        <router-view></router-view>
        <h3>{{$t("Goods.title")}}</h3>
            <div class="text-center" v-cloak>
                <router-link  :to= "{name: 'creategood', params: {id: this.category_id}}">
                    <button class="button is-primary is-small">
                       {{$t("Goods.buttonCreate")}}
                    </button>
                </router-link>
                <router-link  :to= "{name: 'addgood',params: {id: this.category_id}}">
                    <button class="button is-primary is-small">
                       {{$t("Goods.buttonAdd")}}
                    </button>
                </router-link>
            </div>
        <hr>
             <v-server-table
                    :url="url"
                    :columns="columns"
                    :options="options"
                    ref="goods"
             ></v-server-table>
            <pagination-table></pagination-table>  
    </div>
</template>

<script>

    import Vue from 'vue'
    import {ServerTable, Event} from 'vue-tables-2';
    import ActionsGood from './ActionsGood.vue';
    import Photo from './Photo.vue';

    Vue.component('photo-good',Photo);
    Vue.component('actions-good',ActionsGood);

    Vue.use(ServerTable,{
                            texts: {
                            },
                            requestKeys: {
                                limit: "per_page"
                            },    
                            perPage: 5,
                            perPageValues: [5, 10, 25],
                            pagination: {
                                dropdown: true,    
                            },
                            responseAdapter: function (resp) {
                                return {
                                    data: resp.data,
                                    count: resp.total
                                }
                            }
    });


    export default {
        created() {
            window.busevents.$on('refreshgood', this.refreshgoods);
            window.busevents.$on('creategoods',this.addGoods);
            window.busevents.$on('editgoods',this.updateGoods);
            window.busevents.$on('deletegood',this.deleteGoods);
            window.busevents.$on('getgoods', this.getgoods);
        },
        mounted(){
            this.$refs.goods._data.globalOptions.texts = {
                filter: this._i18n.t("ServerTableLabels.filter"),
                limit: this._i18n.t("ServerTableLabels.limit"),
                loading: this._i18n.t("ServerTableLabels.loading"),
                page: this._i18n.t("ServerTableLabels.page"),
                noResults: this._i18n.t("ServerTableLabels.noResults"),
                filterPlaceholder: this._i18n.t("ServerTableLabels.filterPlaceholder"),
                count: "",
            };
            this.options.headings = {
                id: this._i18n.t("ServerTableHeadings.id"),
                name: this._i18n.t("ServerTableHeadings.name"),
                photo: this._i18n.t("ServerTableHeadings.photo"),
                description: this._i18n.t("ServerTableHeadings.description"),
                edit: this._i18n.t("ServerTableHeadings.edit"),
            };
        },
       name: "good_list",
       data: function() {
            return {
              url: this.$root.prefix_url + '/goods/1',
              category_id: '',  
              columns: ['id', 'name', 'photo', 'description','edit'],
              options: {
                  headings: {

                  },
                  templates: {
                       photo: 'photo-good',
                       edit: 'actions-good'
                  },
              },
            }
      },
      methods: {
          refreshgoods: function (){
                this.$refs.goods.url = this.url;
                this.$refs.goods.getData();
          },
          addGoods: function (goods){
                this.$refs.goods.data.push(goods);
                this.$refs.goods.count++;
          },
          updateGoods: function (goods){
              this.$refs.goods.data.forEach(function(row,index,elements){
                  if (row.id == goods.id){
                      elements[index].name = goods.name;
                      elements[index].description = goods.description;
                      elements[index].photo = goods.photo;
                  }
              });
          },
          deleteGoods: function (goods_id){
              this.$refs.goods.data.forEach(function(row,index,elements){
                  if (row.id == goods_id) {
                      elements.splice(index, 1);
                  }
              });
          },
          getgoods: function (id) {
                this.category_id = id;
                this.url = this.$root.prefix_url + '/goods/' + id;
                this.refreshgoods();
                window.busevents.$emit('refreshtable',id);
          }
      },
    }
</script>




