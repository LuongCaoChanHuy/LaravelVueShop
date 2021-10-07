<template>
    <div v-if="isLoggedIn">
        Welcome Home
    </div>
    <div v-else>
        <main role="main" class="inner cover" style="text-align:center; margin-top:5%">
            <h1 class="cover-heading">Admin your page.</h1>
            <br>
            <p class="lead">Please log in, to access the management of ingredients your way!</p>
            
            <p class="lead">
            <!-- <a href="#" class="btn btn-lg btn-secondary">Go Dashboard</a> -->
            <router-link to="/login" class="btn btn-lg btn-secondary">Go Dashboard</router-link>
            </p>
        </main>
        <br>
        <footer class="mastfoot mt-auto" style="text-align:center">
            <div class="inner">
            <p>Admin page for @company lcch-lrv</p>
            </div>
        </footer>
    </div>
    
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            isLoggedIn: false,
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    methods: {}
}
</script>