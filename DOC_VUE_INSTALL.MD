## Installasi vue 3 & membuat vue komponen

1. jalankan `npm install` pada termnal
2. install vue 3 `npm install --save vue@next && npm install --save-dev vue-loader@next`
3. menambahkan vue ke file webpack.mix.js
    ```bash
    const mix = require('laravel-mix');
    /*
    |--------------------------------------------------------------------------
    | Mix Asset Management
    |--------------------------------------------------------------------------
    |
    | Mix provides a clean, fluent API for defining some Webpack build steps
    | for your Laravel applications. By default, we are compiling the CSS
    | file for the application as well as bundling up all the JS files.
    |
    */
    mix.js('resources/js/app.js', 'public/js')
       .vue()
       .postCss('resources/css/app.css', 'public/css', [
         //
       ]);
    ```
4. Membuat vue component (welcome page), buat file /resources/js/components/demo/Welcome.vue dengan code di bawah :
    ```vue
        <template>
        <h1>{{ title }}</h1>
        </template>
        <script>
        export default {
            setup: () => ({
                title: 'welcome...ini vue komponen'
            })
        }
        </script>
      ```
5. import vue dan componen yg dibuat di atas dalam file /resources/js/app.js

    ```js
    require('./bootstrap');

    import { createApp } from 'vue'

    /** DEMO COMPONENT*/
    import Welcome from './components/demo/Welcome.vue';
    /** END DEMO COMPONENT*/

    const app = createApp({});

    //register komponen kedalam vue app
    /** DEMO COMPONENT*/
    app.component('welcome-vue-component', Welcome)
    /** END DEMO COMPONENT*/

    app.mount('#app')
    ```
6. ubah file /resource/views/welcome.blade.php untuk element vue app dengan code di bawah

    ```html
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>ePos - Alwafi</title>
            <!-- Fonts -->
            <!-- Styles -->
            <style>

            </style>
        </head>
        <body >
            <div id="app">

                <welcome-vue-component/>
            </div>
            <script src="{{ mix('js/app.js') }}"></script>
        </body>
    </html>
    ```
7. pastikan  route pada /routes/web.php seperti di bawah :

    ```php
        Route::get('/', function () {
           return view('welcome');
        });

        Route::get('/{any}', function () {
            return view('welcome');
        })->where('any', '.*');
    ```
8. jalankan `npm run watch` pada terminal, dan akses url aplikasi pada browser.jika tidak ada erro maka pada browserakan muncul halaman welcome
