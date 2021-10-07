<template>
   <!-- ADMIN -->
   <div v-if="isLoggedIn">
      <!-- NAVBAR -->
      <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
         <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
         <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
         <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap" style="color:#fff">
               {{ name }}
            </li>
         </ul>
         <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
               <a class="nav-link" @click="logout" href="#">Sign out</a>
            </li>
         </ul>
      </nav>
      <!-- NAVBAR -->
      <!-- ====================================================================================== -->
      <!-- SIDEBAR -->
      <div class="container-fluid">
         <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
               <div class="sidebar-sticky">
                  <ul class="nav flex-column">
                     <li class="nav-item">
                        <router-link class="nav-link active" to="/dashboard">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                              <polyline points="9 22 9 12 15 12 15 22"></polyline>
                           </svg>
                           Dashboard <span class="sr-only">(current)</span>
                        </router-link>
                     </li>
                     <li class="nav-item">
                        <router-link class="nav-link" to="/orders">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                              <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                              <polyline points="13 2 13 9 20 9"></polyline>
                           </svg>
                           Orders
                        </router-link>
                     </li>
                     <li class="nav-item">
                        <router-link to="/products" class="nav-link">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart">
                              <circle cx="9" cy="21" r="1"></circle>
                              <circle cx="20" cy="21" r="1"></circle>
                              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                           </svg>
                           Products
                        </router-link>
                     </li>
                     <li class="nav-item">
                        <router-link class="nav-link" to="/customers">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                              <circle cx="9" cy="7" r="4"></circle>
                              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                           </svg>
                           Customers
                        </router-link>
                     </li>
                     <li class="nav-item">
                        <router-link to="/categories" class="nav-link">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                              <line x1="18" y1="20" x2="18" y2="10"></line>
                              <line x1="12" y1="20" x2="12" y2="4"></line>
                              <line x1="6" y1="20" x2="6" y2="14"></line>
                           </svg>
                           Category
                        </router-link>
                     </li>
                     <li class="nav-item">
                        <router-link class="nav-link" to="/authors">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                              <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                              <polyline points="2 17 12 22 22 17"></polyline>
                              <polyline points="2 12 12 17 22 12"></polyline>
                           </svg>
                           Author
                        </router-link>
                     </li>
                  </ul>
                  <!-- Report -->
                  <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                     <span>Saved reports</span>
                     <a class="d-flex align-items-center text-muted" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                           <circle cx="12" cy="12" r="10"></circle>
                           <line x1="12" y1="8" x2="12" y2="16"></line>
                           <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                     </a>
                  </h6>
                  <ul class="nav flex-column mb-2">
                     <li class="nav-item">
                        <a class="nav-link" href="#">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                              <polyline points="14 2 14 8 20 8"></polyline>
                              <line x1="16" y1="13" x2="8" y2="13"></line>
                              <line x1="16" y1="17" x2="8" y2="17"></line>
                              <polyline points="10 9 9 9 8 9"></polyline>
                           </svg>
                           Current month
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                              <polyline points="14 2 14 8 20 8"></polyline>
                              <line x1="16" y1="13" x2="8" y2="13"></line>
                              <line x1="16" y1="17" x2="8" y2="17"></line>
                              <polyline points="10 9 9 9 8 9"></polyline>
                           </svg>
                           Last quarter
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                              <polyline points="14 2 14 8 20 8"></polyline>
                              <line x1="16" y1="13" x2="8" y2="13"></line>
                              <line x1="16" y1="17" x2="8" y2="17"></line>
                              <polyline points="10 9 9 9 8 9"></polyline>
                           </svg>
                           Social engagement
                        </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">
                           <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                              <polyline points="14 2 14 8 20 8"></polyline>
                              <line x1="16" y1="13" x2="8" y2="13"></line>
                              <line x1="16" y1="17" x2="8" y2="17"></line>
                              <polyline points="10 9 9 9 8 9"></polyline>
                           </svg>
                           Year-end sale
                        </a>
                     </li>
                  </ul> -->
                  <!-- Report -->
               </div>
            </nav>
            <router-view></router-view>
         </div>
      </div>
      <!-- SIDEBAR -->
   </div>
   <!-- ADMIN -->
   <!-- ========================================================================================= -->
   <!-- HOME PAGE -->
   <div class="cover-container d-flex h-100 p-3 mx-auto flex-column" v-else>
      <header class="masthead mb-auto">
         <div class="inner">
            <h3 class="masthead-brand" style="margin-left:10%">Admin</h3>
            <nav class="nav nav-masthead justify-content-center" style="margin-right:10%">
               <router-link to="/" class="nav-item nav-link">Home</router-link>
               <router-link to="/login" class="nav-item nav-link">Sign in</router-link>
               <a class="nav-link" href="#">Contact</a>
            </nav>
         </div>
      </header>
      <router-view></router-view>
   </div>
   <!-- END HOME PAGE --> 
</template>
<script>
   export default {
       name: "App",
       data() {
           return {
               isLoggedIn: false,
               status: 0
           }
       },
       created() {
            if (window.Laravel.isLoggedin) {
               this.isLoggedIn = true;
               this.status = window.Laravel.user.status;
            }
            if (window.Laravel.user) {
               this.name = window.Laravel.user.name
            }
       },
       methods: {
           logout(e) {
               console.log('ss')
               e.preventDefault()
               this.$axios.get('/sanctum/csrf-cookie').then(response => {
                   this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
               })
           }
       },
   }
</script>
<style>
@-webkit-keyframes chartjs-render-animation{
    from{
        opacity:0.99
    }to{
        opacity:1
    }
}
@keyframes chartjs-render-animation{
    from{
        opacity:0.99
    }to{
        opacity:1
    }
}.chartjs-render-monitor{
    -webkit-animation:chartjs-render-animation 0.001s;
    animation:chartjs-render-animation 0.001s;
}
body {
    font-size: .875rem;
}

.feather {
    width: 16px;
    height: 16px;
    vertical-align: text-bottom;
}

/*
* Sidebar
*/

.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100; /* Behind the navbar */
    padding: 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 48px; /* Height of navbar */
    height: calc(100vh - 48px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

.sidebar .nav-link {
    font-weight: 500;
    color: #333;
}

.sidebar .nav-link .feather {
    margin-right: 4px;
    color: #999;
}

.sidebar .nav-link.active {
    color: #007bff;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
    color: inherit;
}

.sidebar-heading {
    font-size: .75rem;
    text-transform: uppercase;
}

/*
* Navbar
*/

.navbar-brand {
    padding-top: .75rem;
    padding-bottom: .75rem;
    font-size: 1rem;
    background-color: rgba(0, 0, 0, .25);
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
}

.navbar .form-control {
    padding: .75rem 1rem;
    border-width: 0;
    border-radius: 0;
}

.form-control-dark {
    color: #999;
    background-color: #999;
    border-color: #999;
}

.form-control-dark:focus {
    border-color: transparent;
    box-shadow: 0 0 0 3px #999;
}

/*
* Utilities
*/

.border-top { 
    border-top: 1px solid #e5e5e5; 
}
.border-bottom { 
    border-bottom: 1px solid #e5e5e5; 
}

/* 
* Home page
*/

/*
* Globals
*/

/* Links */
a,
a:focus,
a:hover {
color: #999;
}

/* Custom default button */
.btn-secondary,
.btn-secondary:hover,
.btn-secondary:focus {
color: #333;
text-shadow: none; /* Prevent inheritance from `body` */
background-color: #999;
border: .05rem solid #999;
}


/*
* Base structure
*/
.cover-container {
max-width: 70%;
}


/*
* Header
*/
.masthead {
margin-bottom: 2rem;
}

.masthead-brand {
margin-bottom: 0;
}

.nav-masthead .nav-link {
padding: .25rem 0;
font-weight: 700px;
color: #999;
background-color: transparent;
border-bottom: .25rem solid transparent;
}

.nav-masthead .nav-link:hover,
.nav-masthead .nav-link:focus {
border-bottom-color: #999;
}

.nav-masthead .nav-link + .nav-link {
margin-left: 1rem;
}

.nav-masthead .active {
color: #999;
border-bottom-color: #999;
}

@media (min-width: 48em) {
.masthead-brand {
    float: left;
}
.nav-masthead {
    float: right;
}
}


/*
* Cover
*/
.cover {
padding: 0 1.5rem;
}
.cover .btn-lg {
padding: .75rem 1.25rem;
font-weight: 700;
}


/*
* Footer
*/
.mastfoot {
color: #999;
}
</style>