/*=========================================================================================
  File Name: vue.config.js
  Description: configuration file of vue
  ----------------------------------------------------------------------------------------
  Item Name: VietNam HouseWares Admin Dashboard
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


module.exports = {
    publicPath: '/',
    transpileDependencies: [
        'vue-echarts',
        'resize-detector'
    ],
    configureWebpack: {
        optimization: {
            splitChunks: {
                chunks: 'all'
            }
        }
    }
    // devServer: {
    //   overlay: {
    //     warnings: true,
    //     errors: true
    //   }
    // }
}

