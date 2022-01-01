<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark text-capitalize ">{{fixName($route.name)}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item" v-if="$route.name !=='dashboard'">
                  <router-link :to="{ name: 'dashboard' }">
                  <!-- <i class="fas fa-tachometer-alt nav-icon mr-2"></i> -->Dashboard
                </router-link>
                </li>
                <li class="breadcrumb-item active text-capitalize">{{fixName($route.name)}}</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

        <router-view 
            :role="role"
            :user="user"
            :token="token"
        />

    </div>
    <!-- /.content-wrapper -->    
</template>

<script>
    
    export default {
        props: {
          role: String,
          token: String,
          user: {
          type: Object
        },
        },
        mounted() {
            console.log('Content wrapper mounted.')
        },
        methods: {
            fixName(name) {
                const NAME = `${name}`;
                if(!NAME.includes('-')) return NAME;

                let nameArray = NAME.split('-');
                let newName = ''; 
                nameArray.forEach(element => {
                    newName = `${newName} ${element}`;
                });
                return newName;
            }
        }
    }
</script>
<style lang="scss" scoped>    
    // .layout-boxed .content-wrapper, .layout-boxed .main-header, .layout-boxed .main-footer {
    //     z-index: 0; 
    // }
</style>