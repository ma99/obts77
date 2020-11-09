<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Home Page</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/dashboard">
                    <i class="fas fa-dashboard nav-icon"></i>Dashboard
                  </router-link>
                </li>
                <li class="breadcrumb-item active">Home</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="ribbon-wrapper">
                <div class="ribbon bg-primary">
                  Ribbon
                </div>
              </div>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>

                  <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the card's
                    content.
                  </p>

                  <a href="#" class="card-link" @click.prevent="removeSideBarMini('remove', ['hold-transition', 'sidebar-mini', 'hello-world'])">Remove Sidebar Mini</a>
                  <a href="#" class="card-link">Card link</a>
                  <a href="#" class="card-link">Another link</a>
                </div>
              </div>

              <div class="card card-primary card-outline">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>

                  <p class="card-text">
                    Some quick example text to build on the card title and make up the bulk of the card's
                    content.
                  </p>
                  <a href="#" class="card-link">Card link</a>
                  <a href="#" class="card-link">Another link</a>
                </div>
              </div><!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
