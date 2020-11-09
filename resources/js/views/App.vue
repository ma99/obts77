<template>
  <h1>Named Views</h1>
  <br />
  <span class="text-primary"> {{ user.name }} </span>
  <div>
    <ul>
        <li>
          <router-link :to="{ name: 'first' }">First page</router-link>
        </li>
        <li>
          <!-- <router-link :to="{ name: 'second'}">Second page</router-link> -->
          <a href="#" @click.prevent="goToSecondPage">Second Page</a>
        </li>
      </ul>      
  </div>
  
  <router-view></router-view>
  
</template>

<script>
  export default {
    // name: "App",
    props: ['user'],
    computed: {
        authenticated() {
            return (this.user.name == 'ma') ?
                true : false;
        }
    },
    methods: {
        goToSecondPage() {
            if(this.authenticated) {
                this.$router.push({ name: 'second' })
            } else {                
                console.log('Not Allowed');
            }
        }
    }
  }
</script>