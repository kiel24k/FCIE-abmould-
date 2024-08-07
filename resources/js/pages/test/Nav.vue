<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <router-link class="nav-link" to="/nav">Home</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/test-login">Login</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/test-post">Post</router-link>
            </li>
          </ul>

        </div>
      </nav>
      <div>
        <h1>Home</h1>
      </div>
</template>

<style scoped>
.router-link-active,.router-link-exact-active{
    background: red;
}
</style>
