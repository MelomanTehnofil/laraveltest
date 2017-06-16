/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

module.exports = {
  // ...
  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js' // 'vue/dist/vue.common.js' for webpack 1
    }
  },
  module: {
            rules: [
              {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: {
                          preLoaders: {
                            js: 'vue-template-compiler'
                          },
                    }
              }
        ]
    }

}
