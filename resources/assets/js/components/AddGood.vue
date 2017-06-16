<template>
    <div class="modal is-active">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">{{$t("AddGood.title")}}</p>
            </header>
            <section class="modal-card-body">
                <v-server-table
                    :url="url"
                    :columns="columns"
                    :options="options"
                    ref="goods"
                 ></v-server-table>                
            </section>
            <footer class="modal-card-foot">
                <p class="control">
                    <button @click="selectGood" class="button is-primary is-small">
                        {{$t("AddGood.buttonSave")}}
                    </button>
                </p>
                <p>
                    <router-link :to="{name: '/'}">
                      <button class="button is-small">
                         {{$t("AddGood.buttonCancel")}}
                      </button>                
                    </router-link>
                </p>
            </footer>
          </div>
    </div> 
</template>

<script>
    import Vue from 'vue'
    import {ServerTable} from 'vue-tables-2';
    import SelectGood from './SelectGood.vue';

    Vue.component('select-good',SelectGood);

    Vue.use(ServerTable,{
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
        created(){
            window.busevents.$on('checkedrowadd',this.addGood);
            window.busevents.$on('checkedrowtrash',this.trashGood);
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
                select: this._i18n.t("ServerTableHeadings.id"),
                name:   this._i18n.t("ServerTableHeadings.name"),
            };
        },
        data: function() {
            return {
                urlmove: this.$root.prefix_url + '/movegood',
                category_id: this.$route.params.id,
                selectedrows: [], 
                url: this.$root.prefix_url + '/goodsall',
                columns: ['select', 'name'],
                options: {
                    headings: {
                    },
                  templates: {
                       select: 'select-good',
                  },
              },
        }
      },
      methods:{
        selectGood: function(){
                let formData = new FormData();
                formData.append('category', this.category_id);
                formData.append('goods', JSON.stringify(this.selectedrows));
                this.submit(this.urlmove,formData);
                this.closeForm();
        },
        submit: function(url,formData){
                this.$http.post(url, formData)
                    .then(response => {
                        window.busevents.$emit('refreshgood');
                    }).catch(response => {
                        console.log('ADD_GOODS_ERROR!');
                    });
                
        },
        closeForm(){
             this.$root._router.back();                
        },
        addGood: function(rowid){
            if (this.selectedrows.indexOf(rowid) == -1) {
                this.selectedrows.push(rowid);
            }
        },
        trashGood: function(rowid){
            var index = this.selectedrows.indexOf(rowid);
            if (index != -1) {
                this.selectedrows.splice(index,1);
            }
        },
      },
    }
</script>
