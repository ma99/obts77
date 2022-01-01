<template>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            ALL my notifications here content
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
            console.log('Notifications mounted.')
        }
    }
</script>
