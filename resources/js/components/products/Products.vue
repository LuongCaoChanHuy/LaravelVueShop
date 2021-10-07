<template>
   <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
      <div class="table-responsive">
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Product Manager</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
               <div class="btn-group mr-2">
                  <button class="btn btn-sm btn-outline-secondary">Share</button>
                  <button class="btn btn-sm btn-outline-secondary">Export</button>
               </div>
               <button class="btn btn-sm btn-outline-secondary" @click="showSearch">Search</button>
               <!-- <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                     <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                     <line x1="16" y1="2" x2="16" y2="6"></line>
                     <line x1="8" y1="2" x2="8" y2="6"></line>
                     <line x1="3" y1="10" x2="21" y2="10"></line>
                  </svg>
                  This week
                  </button> -->
               <button class="btn btn-sm btn-outline-secondary" @click="createFetch" id="create" data-toggle="modal" data-target="#addProduct">Create</button>
            </div>
         </div>
         <div class="panel panel-default" id="search" style="display:none">
            <div class="panel-heading">
               <strong>Search Product</strong>
            </div>
            <div class="row">
               <div class="search-wrapper panel-heading col-sm-12">
                  <input class="form-control" type="text" v-model="searchQuery" placeholder="Search" />
               </div>
            </div>
            <!-- <div class="table-responsive">
               <table v-if="resources.length" class="table">
                  <thead>
                     <tr>
                        <th>Resource</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr v-for="item in resultQuery(this.resources)" :key="item.title">
                        <td><a v-bind:href="item.uri" target="_blank">{{item.title}}</a></td>
                     </tr>
                  </tbody>
               </table>
               </div> -->
         </div>
         <br>
         <table class="table">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <tr v-for="product in resultQuery(products)" :key="product.id">
                  <td>{{ product.id }}</td>
                  <td>
                     <img class="rounded" height="200" width="124" v-bind:src="'/images/'+product.image" /> 
                  </td>
                  <td>{{ product.title }}</td>
                  <td>{{ product.author.name }}</td>
                  <td>{{ product.category.name }}</td>
                  <td>{{ product.price }}</td>
                  <td>{{ product.store }}</td>
                  <td>{{ product.created_at }}</td>
                  <td>{{ product.updated_at }}</td>
                  <td>
                     <div class="btn-group mr-2" role="group">
                        <!-- <router-link :to="{name: 'editproduct', params: { id:product.id }}" class="btn btn-primary">Edit
                           </router-link> -->
                        <!-- <button class="btn btn-success" data-toggle="modal" data-target="#addProduct">Add</button> -->
                        <button class="btn btn-sm btn-outline-secondary" @click="editProduct(product)" data-toggle="modal" data-target="#addProduct" >Edit</button>
                        <button class="btn btn-sm btn-outline-secondary" @click="deleteProduct(product.id)">Delete</button>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
            </tbody>
         </table>
      </div>
      <!-- Pagination -->
      <div class="d-flex justify-content-center">
         <nav aria-label="Page navigation example">
            <ul class="pagination">
               <li class="page-item" :class="[{disable:!pagination.prev_page_url}]">
                  <a class="page-link" href="#" aria-label="Previous"
                     @click="fetchProducts(pagination.prev_page_url)">
                  <span aria-hidden="true">&laquo;</span>
                  </a>
               </li>
               <li v-for="num_page in pagination.last_page" :key="num_page" class="page-item">
                  <a class="page-link" @click="fetchProducts(pagination.path+`?page=`+num_page)" href="#">{{num_page}}</a>
               </li>
               <li class="page-item" :class="[{disable:!pagination.next_page_url}]">
                  <a class="page-link" href="#" aria-label="Next"
                     @click="fetchProducts(pagination.next_page_url)">
                  <span aria-hidden="true">&raquo;</span>
                  </a>
               </li>
            </ul>
         </nav>
      </div>
   </main>
   <!-- Modal Add & Edit Product -->
   <div class="modal fade" id="addProduct" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addProduct">Add Product</h5>
               <p id="productAddSuccess"></p>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form @submit.prevent="addProduct" enctype="multipart/form-data">
               <div class="modal-body">
                  <div class="form-group">
                     <label for="input">Name</label>
                     <input type="text" class="form-control" v-model="product.title" id="input" placeholder="Name">
                  </div>
                  <div class="form-group">
                     <label for="input1">author</label>
                     <input type="text" class="form-control" v-model="inputAuthor" id="input1" placeholder="author">
                     <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-bordered table-striped mb-0">
                           <tbody>
                              <tr v-for="author in filterAuthor(authors)" :key="author.name">
                                 <td @click="bindAuthor(author)"><a target="_blank">{{author.name}}</a></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="input3">category</label>
                     <select class="form-control" id="selectCategory">
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="input2">Price</label>
                     <input type="number" class="form-control" v-model="product.price" id="input2" placeholder="Price">
                  </div>
                  <div class="form-group">
                     <label for="input4">Quantity</label>
                     <input type="number" class="form-control" v-model="product.store" id="input4" placeholder="Quantity">
                  </div>
                  <div class="form-group">
                     <input type="file" accept="image/*" @change="onChange" ref="file" id="image"/>
                     <br><br>
                     <div id="preview" class="d-flex justify-content-center">
                        <img class="shadow p-3 mb-5 bg-white rounded border border-secondary" 
                           height="500" width="310" v-if="item.imageUrl" :src="item.imageUrl" />
                        <img class="shadow p-3 mb-5 bg-white rounded border border-secondary" 
                           height="500" width="310" v-else v-bind:src="'/images/'+product.image" />
                     </div>
                     <!-- <div v-else id="preview" class="d-flex justify-content-center">
                        <img class="shadow p-3 mb-5 bg-white rounded border border-secondary" 
                        height="500" width="310" v-if="item.imageUrl" :src="item.imageUrl" />
                        </div> -->
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="modalClose(pagination.path+`?page=`+pagination.current_page)" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</template>
<script>
   export default {
       data() {
           return {
              //object
               products:[]  
               ,product:{}
               ,authors:[]
               ,author:{}
               ,categories:[]
               ,category:{}
               ,item:{
                  image:null,
                  imageUrl:null
               }
               ,file:{}
               ,pagination:{}  
               ,edit:false
               ,searchQuery:null
               ,inputAuthor:null
               ,searchProducts:[]     
           }
       },
       created() {
           this.fetchProducts();
       },
       methods: {
            fetchProducts(page_url){
               let vm = this;
               let page = page_url || '/api/products';
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                fetch(page)
                 .then(response=>response.json())
                 .then(response => {
                     this.products = response.data;
                     vm.makePagination(response.meta,response.links);
                 })
                 .catch(function (error) {
                     console.error(error);
                 });
               });
            },
            createFetch(){
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                  fetch('/api/authors-search')
                  .then(response=>response.json())
                  .then(response => {
                        this.authors = response.data;
                  })
                  .catch(function (error) {
                        console.error(error);
                  });
                  fetch('/api/categories')
                  .then(response=>response.json())
                  .then(response => {
                        this.categories = response.data;
                  })
                  .catch(function (error) {
                        console.error(error);
                  });
               });
            },
            searchFetch(){
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                  fetch('/api/products-search')
                 .then(response=>response.json())
                 .then(response => {
                     this.searchProducts = response.data;
                     this.products = this.searchProducts;
                 })
                 .catch(function (error) {
                     console.error(error);
                 });
               });
            },
            addProduct() {
              if(this.edit == false){
               var select = document.getElementById('selectCategory');
   	         var option = select.options[select.selectedIndex];
               let formData = new FormData();
               formData.append('title',this.product.title);
               formData.append('author_id',this.author.id);
               formData.append('author_name',this.inputAuthor);
               formData.append('category_id',option.value);
               formData.append('price',this.product.price);
               formData.append('store',this.product.store);
               if(document.getElementById('image').files[0]){
                  formData.append('image',document.getElementById('image').files[0]);
               }
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('/api/products', formData)
                        .then(response => {
                            this.$router.push({name: 'products'});
                            alert('Add Success !');
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                });
              }else{
                  var select = document.getElementById('selectCategory');
                  var option = select.options[select.selectedIndex];
                  let formData = new FormData();
                  formData.append('title',this.product.title);
                  formData.append('author_id',this.author.id);
                  formData.append('author_name',this.inputAuthor);
                  formData.append('category_id',option.value);
                  formData.append('price',this.product.price);
                  formData.append('store',this.product.store);
                  if(document.getElementById('image').files[0]){
                     formData.append('image',document.getElementById('image').files[0]);
                  }
               formData.append("_method","PUT");
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post(`/api/products/${this.product.id}`,formData)
                        .then(response => {
                            this.$router.push({name: 'products'});
                            alert('Update Success !');
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                });
             
              }
            },
            deleteProduct(id) {
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                   this.$axios.delete(`/api/products/${id}`)
                       .then(response => {
                           let i = this.products.map(item => item.id).indexOf(id); // find index of your object
                           this.products.splice(i, 1)
                       })
                       .catch(function (error) {
                           console.error(error);
                       });
               })
            },
            editProduct(eproduct){
               this.createFetch();
              this.product.title = eproduct.title;
              this.inputAuthor = eproduct.author.name;
              this.product.price = eproduct.price;
              this.product.store = eproduct.store;
              this.edit = true;
              this.product = eproduct;
            },
            makePagination(meta,links) {
               let pagination = {
                   current_page:meta.current_page,
                   last_page:meta.last_page,
                   next_page_url:links.next,
                   prev_page_url:links.prev,
                   path:meta.path
               };
               this.pagination = pagination;
            },
            onChange(e) {
               // document.getElementById('showImg').setAttribute('hidden','nullabled');
               const file = e.target.files[0];
               this.image = file;
               this.item.imageUrl = URL.createObjectURL(file);
            },
            modalClose(page){
               this.inputAuthor = "",
               this.product.title = "";
               this.product.price = 0;
               this.product.store = 0;
               this.edit = false;
               this.fetchProducts(page);
            },
            resultQuery(resources){
               if(this.searchQuery){
                  return resources.filter((item)=>{
                     return this.searchQuery.toLowerCase()
                     .split(' ').every(v => item.title.toLowerCase().includes(v))
                  })
               }else{
                  return resources;
               }
            },
            filterAuthor(resources){
               if(this.inputAuthor){
                  return resources.filter((item)=>{
                     return this.inputAuthor.toLowerCase()
                     .split(' ').every(v => item.name.toLowerCase().includes(v))
                  })
               }else{
                  this.author.id = -1;
                  return resources;
               }
            },
            bindAuthor(author){
               this.inputAuthor = author.name;
               this.author = author;
            },
            showSearch(){
               var x = document.getElementById("search");
               if (x.style.display === "none") {
                  x.style.display = "block";
               } else {
                  x.style.display = "none";
               };
               this.searchFetch();
               
            },
       },
       beforeRouteEnter(to, from, next) {
         if (!window.Laravel.isLoggedin) {
             window.location.href = "/";
         }
         next();
       }
   }
</script>
<style>
   .uploading-image{
   display:flex;
   }
   .my-custom-scrollbar {
   position: relative;
   height: 200px;
   overflow: auto;
   }
   .table-wrapper-scroll-y {
   display: block;
   }
</style>