<template>
    <div class="container" :class="{'loading': loading}">
        <div v-show="!user">
            <br/>
            <br/>

            <form action="#" @submit.prevent="login">
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>
                    <div class="col-md-6">
                        <input type="email" id="email" class="form-control" name="email" required autocomplete="email" autofocus v-model="loginData.email">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                    <div class="col-md-6">
                        <input type="password" id="password" class="form-control" name="password" required autocomplete="password" autofocus v-model="loginData.password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary" @click="login">
                            Login
                        </button>
                    </div>
                </div>

            </form>

        </div>

        <div class="row" v-show="user">
            <div class="col-lg-3">
                <h1 class="my-4">Shop Catalogs</h1>
                <a  href="/categories/create">Craete Category</a>
                <div class="list-group">
                    <a class="list-group-item" v-for="category in categories">
                        {{ category.name }}
                    </a>
                </div>

            </div>
            <div class="col-lg-9">
                <div class="row mt-4">
                    <div class="col-lg-4 col-md-6 mb-4" v-for="product in products.data">
                        <div class="card h-100">
                            <a href="#">
                                <img class="card-img-top" src="" alt="">
                            </a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="#">{{ product.name }}</a>
                                </h4>
                                <h5>$ {{ product.price }}</h5>
                                <p class="card-text">{{ product.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <pagination :data="products" @pagination-change-page="loadProducts"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                categories: [],
                products: {},
                loading: true,
                user: false,
                loginData:{
                    email:'',
                    password:''
                }
            }
        },

        created() {
            this.loadCategories();
            this.loadProducts();
        },

        mounted(){
            console.log('mounted');
            
        },


        methods: {
            login:function(){
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', this.loginData).then(response => {
                        console.log(response);
                        this.user = true;
                        this.loadCategories();
                        this.loadProducts(); 
                    }).catch(error => console.log(error));
                });
            },

            loadCategories: function () {
                axios.get('/api/V1/categories')
                    .then((response) => {
                        this.categories = response.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },

            loadProducts(page = 1) {
                axios.get('/api/V1/products?page=' + page)
                    .then((response) => {
                        this.products = response.data;
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    }
</script>
