<template>
   <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
      <div class="table-responsive">
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Author Manager</h1>
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
               <button class="btn btn-sm btn-outline-secondary" @click="createFetch" id="create" data-toggle="modal" data-target="#addauthor">Create</button>
            </div>
         </div>
         <div class="panel panel-default" id="search" style="display:none">
            <div class="panel-heading">
               <strong>Search author</strong>
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
               <tr v-for="author in resultQuery(authors)" :key="author.id">
                  <td>{{ author.id }}</td>
                 
                  <td>{{ author.name }}</td>
               
               
                  <td>{{ author.created_at }}</td>
                  <td>{{ author.updated_at }}</td>
                  <td>
                     <div class="btn-group mr-2" role="group">
                        <!-- <router-link :to="{name: 'editauthor', params: { id:author.id }}" class="btn btn-primary">Edit
                           </router-link> -->
                        <!-- <button class="btn btn-success" data-toggle="modal" data-target="#addauthor">Add</button> -->
                        <button class="btn btn-sm btn-outline-secondary" @click="editauthor(author)" data-toggle="modal" data-target="#addauthor" >Edit</button>
                        <button class="btn btn-sm btn-outline-secondary" @click="deleteauthor(author.id)">Delete</button>
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
                     @click="fetchauthors(pagination.prev_page_url)">
                  <span aria-hidden="true">&laquo;</span>
                  </a>
               </li>
               <li v-for="num_page in pagination.last_page" :key="num_page" class="page-item">
                  <a class="page-link" @click="fetchauthors(pagination.path+`?page=`+num_page)" href="#">{{num_page}}</a>
               </li>
               <li class="page-item" :class="[{disable:!pagination.next_page_url}]">
                  <a class="page-link" href="#" aria-label="Next"
                     @click="fetchauthors(pagination.next_page_url)">
                  <span aria-hidden="true">&raquo;</span>
                  </a>
               </li>
            </ul>
         </nav>
      </div>
   </main>
   <!-- Modal Add & Edit author -->
   <div class="modal fade" id="addauthor" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="addauthor">Add author</h5>
               <p id="authorAddSuccess"></p>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form @submit.prevent="addauthor" enctype="multipart/form-data">
               <div class="modal-body">
                  <div class="form-group">
                     <label for="input">Name</label>
                     <input type="text" class="form-control" v-model="author.name" id="input" placeholder="Name">
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
               authors:[]  
               ,author:{}
               ,pagination:{}  
               ,edit:false
               ,searchQuery:null
               ,searchauthors:[]   
           }
       },
       created() {
           this.fetchauthors();
       },
       methods: {
            fetchauthors(page_url){
               let vm = this;
               let page = page_url || '/api/authors';
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                fetch(page)
                 .then(response=>response.json())
                 .then(response => {
                     this.authors = response.data;
                     vm.makePagination(response.meta,response.links);
                 })
                 .catch(function (error) {
                     console.error(error);
                 });
               });
            },
            searchFetch(){
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                  fetch('/api/authors-search')
                 .then(response=>response.json())
                 .then(response => {
                     this.searchauthors = response.data;
                     this.authors = this.searchauthors;
                 })
                 .catch(function (error) {
                     console.error(error);
                 });
               });
            },
            addauthor() {
              if(this.edit == false){
               let formData = new FormData();
               formData.append('name',this.author.name);
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('/api/authors', formData)
                        .then(response => {
                            this.$router.push({name: 'authors'});
                            alert('Add Success !');
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                });
              }else{
                  let formData = new FormData();
                  formData.append('name',this.author.name);
               formData.append("_method","PUT");
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post(`/api/authors/${this.author.id}`,formData)
                        .then(response => {
                            this.$router.push({name: 'authors'});
                            alert('Update Success !');
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                });
             
              }
            },
            deleteauthor(id) {
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                   this.$axios.delete(`/api/authors/${id}`)
                       .then(response => {
                           let i = this.authors.map(item => item.id).indexOf(id); // find index of your object
                           this.authors.splice(i, 1)
                       })
                       .catch(function (error) {
                           console.error(error);
                       });
               })
            },
            editauthor(eauthor){
              this.author.name = eauthor.name;
              this.edit = true;
              this.author = eauthor;
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
            modalClose(page){
               this.author.name = "";
               this.edit = false;
               this.fetchauthors(page);
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