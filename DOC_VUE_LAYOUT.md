## sample multi layout, Vue Route
membuat multi layout, dimana tampilan layout untuk halaman login dan admin panel / dashboard mempunyai layout tampilan yg berbeda 

1. buat layout untuk halaman login, /resources/js/components/BaseLayout.vue 
    ```vue
    <template>
        <div>
            <slot />
        </div>
    </template>
    
    ```
2. buat layout untuk halaman admin panel / dashboard, /resources/js/components/MainLayout.vue

    ```vue
    <template>
        <div style="width: 100%;height: 20%;background-color: #7FFF00FF">
            Header
        </div>
        <div style="width: 100%;height: 20%;background-color: #e5d3e0;margin-top: 30px">
            <div style="width: 100%;height: 20%;background-color: #e5d3e0;padding: 20px">
                <slot />
            </div>
        </div>
    </template>
    ```
3. Buat komponen halaman lagin,/resources/js/components/demo/Login.vue

    ```vue
        <template>
            <div style="width: 100%;text-align: center;margin-top: 100px;">
              <button @click="doLogin">LOGIN</button>
            </div>
        </template>
        
        <script>
        export default {
            components: {
            },
            setup() {
            },
            created() {
            },
            data() {
            },
            methods : {
                doLogin(){
                    //proses login
                    //login sukses, go to route dashboard (Navigation via push route path)
                    this.$router.push("/dashboard");
                }
            }
        }
        </script>
    ```
4. Buat komponen halaman dashboard,/resources/js/components/demo/Dashboard.vue
    ```vue
    <template>
        <div style="width: 100%;text-align: center">
            INI DASHBOARD
        </div>
    </template>
    
    <script>
    export default {
       
    }
    </script>
    
    ```
5. install library vue router `npm install vue-router`
6. buat routeComponent vue app ,/resources/js/components/App.vue
    ```vue
    <template>
        <component :is="layout">
            <router-view />
        </component>
    </template>
    
    <script>
    import { defineComponent, computed } from "vue";
    import { useRouter } from "vue-router";
    
    const defaultLayout = "default";
    
    export default defineComponent({
        setup() {
            const { currentRoute } = useRouter();
    
            const layout = computed(
                () => `${currentRoute.value.meta.layout || defaultLayout}-layout`
            );
    
            return {
                layout,
            };
        }
    
    });
    </script>
    
    ```

7. ubah file /resources/app.js dengan step di bawah
    - Import semua component yang telah di buat di atas dan buat route halaman dengan hasil seperti di bawah ini
    ```js
    require('./bootstrap');

    import { createApp } from 'vue'
    
    import Main from './components/App.vue';
    import MainLayout from './components/MainLayout.vue';
    import BaseLayout from './components/BaseLayout.vue';
    
    
    /** DEMO COMPONENT*/
    import Welcome from './components/demo/Welcome.vue';
    import Login from './components/demo/Login.vue';
    import Dashboard from './components/demo/Dashboard.vue';
    /** END DEMO COMPONENT*/
    
    const app = createApp(Main);
    app.component('default-layout', MainLayout);
    app.component('base-layout', BaseLayout);
    
    //register komponen kedalam vue app
    /** DEMO COMPONENT*/
    app.component('welcome-vue-component', Welcome)
    /** END DEMO COMPONENT*/
    
    const routes = [
    { path: "/",name: 'index', component: Login, meta: { layout: "base" }, },
    { path: "/login",name: 'login', component: Login, meta: { layout: "base" }, },
    { path: "/dashboard", name: 'dashboard',component: Dashboard },
    ];
    import  { createRouter, createWebHistory }  from 'vue-router';
    const router = createRouter({
    history: createWebHistory(),
    routes
    })
    
    app.use(router);
    app.mount('#app')

    ```

8. ubah file /resource/views/welcome.blade.php untuk element vue app dengan code di bawah
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
                  
            </div>
            <script src="{{ mix('js/app.js') }}"></script>
        </body>
    </html>
    ```
9. jalankan `npm run watch` pada terminal dan akses web melalui browser

## Navigation vue route
1. Buat komponen halaman produk,/resources/js/components/demo/Produk.vue

    ```vue 
    <template>
        <div style="width: 100%;text-align: center;">
            INI PRODUK
        </div>
    </template>
    
    <script>
    export default {
    
    }
    </script>
      ```
2. Import komponen halaman produk pada file /resources/app.js
    ```js
    import Produk from './components/demo/Produk.vue';
    ```
3. tambahkan route ke halaman produk file /resources/app.js dalam const routes
    ```js
    const routes = [
        { path: "/",name: 'index', component: Login, meta: { layout: "base" }, },
        { path: "/login",name: 'login', component: Login, meta: { layout: "base" }, },
        { path: "/dashboard", name: 'dashboard',component: Dashboard },
        { path: "/produk", name: 'produk',component: Produk },
    ];
   ```
4. tambahkan menu navigation pada layout untuk halaman admin panel / dashboard,dalam file /resources/js/components/MainLayout.vue, hasil akhir sbb :
```vue
<template>
    <div style="width: 100%;height: 20%;background-color: #7FFF00FF">
        Header
    </div>
    <div style="width: 100%;height: 20%;background-color: #7FFF00FF;margin-top: 20px;">
        <router-link aria-label="dashboard" to="/dashboard">
            <span >Dashboard</span>
        </router-link>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <router-link aria-label="produk" to="/produk">
            <span >Produk</span>
        </router-link>
    </div>
    <div style="width: 100%;height: 20%;background-color: #e5d3e0;margin-top: 40px;">
        <div style="width: 100%;height: 20%;background-color: #e5d3e0;padding: 20px">
            <slot />
        </div>
    </div>
</template>

```

9. jalankan `npm run watch` pada terminal dan akses web melalui browser
