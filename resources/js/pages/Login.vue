<template>
    <main role="main" class="inner cover" style="text-align:center; margin-top:5%">
        <h1 class="cover-heading">Admin your page.</h1>
        <br>
        <div class="container">
            <div class="row justify-content-center">
              

                    <div class="alert alert-danger" role="alert" v-if="error !== null">
                        {{ error }}
                    </div>

                    <div class="card card-default">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" v-model="email" required
                                            autofocus autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" v-model="password"
                                            required autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
        </div>
    </main>
    <br>
    <footer class="mastfoot mt-auto" style="text-align:center">
        <div class="inner">
        <p>Admin page for @company lcch-lrv</p>
        </div>
    </footer>
  
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: "",
            error: null
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            this.$router.go('/dashboard')
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                })
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>