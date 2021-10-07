<template>
   <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
      <div class="table-responsive">
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Category Manager</h1>
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
               <button class="btn btn-sm btn-outline-secondary" @click="createFetch" id="create" data-toggle="modal" data-target="#addcategory">Create</button>
            </div>
         </div>
         <div class="panel panel-default" id="search" style="display:none">
            <div class="panel-heading">
               <strong>Search category</strong>
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
                  <th>Name</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <tr v-for="category in resultQuery(categories)" :key="category.id">
                  <td>{{ category.id }}</td>
                  <td>{{ category.name }}</td>
                  <td>{{ category.created_at }}</td>
                  <td>{{ category.updated_at }}</td>
                  <td>
                     <div class="btn-group mr-2" role="group">
                        <!-- <router-link :to="{name: 'editcategory', params: { id:category.id }}" class="btn btn-primary">Edit
                           </router-link> -->
                        <!-- <button class="btn btn-success" data-toggle="modal" data-target="#addcategory">Add</button> -->
                        <button class="btn btn-sm btn-outline-secondary" @click="editcategory(category)" data-toggle="modal" data-target="#addcategory" >Edit</button>
                        <button class="btn btn-sm btn-outline-secondary" @click="deletecategory(category.id)">Delete</button>
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
                     @click="fetchcategories(pagination.prev_page_url)">
                  <span aria-hidden="true">&laquo;</span>
                  </a>
               </li>
               <li v-for="num_page in pagination.last_page" :key="num_page" class="page-item">
                  <a class="page-link" @click="fetchcategories(pagination.path+`?page=`+num_page)" href="#">{{num_page}}</a>
               </li>
               <li class="page-item" :class="[{disable:!pagination.next_page_url}]">
                  <a class="page-link" href="#" aria-label="Next"
                     @click="fetchcategories(pagination.next_page_url)">
                  <span aria-hidden="true">&raquo;</span>
                  </a>
               </li>
            </ul>
         </nav>
      </div>
   </main>
   <!-- Modal Add & Edit category -->
   <div class="modal fade" id="addcategory" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addcategory">Add category</h5>
               <p id="categoryAddSuccess"></p>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form @submit.prevent="addcategory" enctype="multipart/form-data">
               <div class="modal-body">
                  <div class="form-group">
                     <label for="input">Name</label>
                     <input type="text" class="form-control" v-model="category.name" id="input" placeholder="Name">
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="modalClose" data-dismiss="modal">Close</button>
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
               categories:[]
               ,category:{}
               ,pagination:{}
               ,edit:false
               ,searchQuery:null
               ,searchCategories:[]
           }
       },
       created() {
           this.fetchcategories();
       },
       methods: {
            fetchcategories(page_url){
               let vm = this;
               let page = page_url || '/api/categories';
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                fetch(page)
                 .then(response=>response.json())
                 .then(response => {
                     this.categories = response.data;
                 })
                 .catch(function (error) {
                     console.error(error);
                 });
               });
            },
            addcategory() {
              if(this.edit == false){
                 let formData = new FormData();
                  formData.append('name',this.category.name);
                  this.$axios.get('/sanctum/csrf-cookie').then(response => {
                     this.$axios.post('/api/categories', formData)
                     .then(response => {
                        this.$router.push({name: 'categories'});
                        alert('Add Success !');
                     })
                     .catch(function (error) {
                        console.error(error);
                     });
                  });
              }else{
                  let formData = new FormData();
                  formData.append('name',this.category.name);
                  formData.append("_method","PUT");
                  this.$axios.get('/sanctum/csrf-cookie').then(response => {
                     this.$axios.post(`/api/categories/${this.category.id}`,formData)
                     .then(response => {
                        this.$router.push({name: 'categories'});
                        alert('Update Success !');
                     })
                     .catch(function (error) {
                        console.error(error);
                     });
                  });
               }
            },
            deletecategory(id) {
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                   this.$axios.delete(`/api/categories/${id}`)
                       .then(response => {
                           let i = this.categories.map(item => item.id).indexOf(id); // find index of your object
                           this.categories.splice(i, 1)
                       })
                       .catch(function (error) {
                           console.error(error);
                       });
               })
            },
            editcategory(ecategory){
              this.category.name = ecategory.name;
              this.edit = true;
              this.category = ecategory;
            },
            modalClose(){
               this.category.name = "";
               this.edit = false;
               this.fetchcategories();
            },
            resultQuery(resources){
               if(this.searchQuery){
                  return resources.filter((item)=>{
                     return this.searchQuery.toLowerCase()
                     .split(' ').every(v => item.name.toLowerCase().includes(v))
                  })
               }else{
                  return resources;
               }
            },
            searchFetch(){
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                  fetch('/api/categories-search')
                 .then(response=>response.json())
                 .then(response => {
                     this.searchCategories = response.data;
                     this.categories = this.searchCategories;
                 })
                 .catch(function (error) {
                     console.error(error);
                 });
               });
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