<template>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- Here goes page content -->
            my notification content
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>     
</template>

<script>
    export default {
        props: {          
          // role: String,
          user: {
            type: Object
          },
        },
        mounted() {
            console.log('Notification mounted.')
        }
    }
</script>
