<template>
    <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li v-if="isSuperAdmin" class="nav-item has-treeview">
            <a href="#" class="nav-link"
              :class="{ active: navItem == 1 }"
              @click="toggleActive(1, false)"
            >
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li>
          <li v-if="isSuperAdmin" class="nav-item has-treeview menu-open">
            <!-- <a href="#" class="nav-link active"> -->
            <a href="#" class="nav-link" 
              :class="{ active: navItem == 2 }"
              @click="toggleActive(2, false)"
              >
              <i class="fas fa-bus-alt nav-icon text-warning"></i>
              <p>
                PRIMARY
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item" @click="toggleActive(21)">
                <router-link :to="{ name:'city' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 21 }"
                >
                  <i class="fas fa-city nav-icon" aria-hidden="true"></i>
                  <p>City</p>
                </router-link> 
              </li>

              <li class="nav-item" @click="toggleActive(22)">
                <router-link :to="{ name:'route' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 22 }"
                >
                  <i class="fas fa-road nav-icon" aria-hidden="true"></i>
                  <p>Route</p> 
                </router-link> 
              </li>

              <li class="nav-item" @click="toggleActive(23)">
                <router-link :to="{ name:'seat-plan' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 23 }"
                >
                  <i class="fas fa-list-alt nav-icon" aria-hidden="true"></i>
                  <p>Seat Plan</p>
                </router-link> 
              </li>

              <li class="nav-item" @click="toggleActive(24)">
                <router-link :to="{ name:'type' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 24 }"
                >
                  <i class="fas fa-layer-group nav-icon" aria-hidden="true"></i>
                  <p>Bus Type </p>
                </router-link> 
              </li>  

              <li class="nav-item" @click="toggleActive(25)">
                <router-link :to="{ name:'bus' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 25  }"
                >
                  <i class="fas fa-bus nav-icon"></i>
                  <p>Bus</p>
                </router-link> 
              </li>                            
              
              <li class="nav-item" @click="toggleActive(26)">
                <router-link :to="{ name:'fare' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 26 }"
                >                    
                    <i class="fas fa-money-bill nav-icon" aria-hidden="true"></i>
                    <p>Fare </p>
                </router-link> 
              </li>
              <li class="nav-item" @click="toggleActive(27)">
                <router-link :to="{ name:'schedule' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 27 }"
                >
                  <i class="fas fa-list-alt nav-icon" aria-hidden="true"></i>
                  <p>Schedule</p>
                </router-link> 
              </li>
              <li class="nav-item" @click="toggleActive(28)">
                <router-link :to="{ name:'stop' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 28 }"
                >
                  <i class="fas fa-link nav-icon" aria-hidden="true"></i>
                  <p>Stop </p>
                </router-link> 
              </li>  
              <!-- <li class="nav-item" @click="toggleActive(28)">
                <router-link :to="{ name:'type' }" 
                  class="nav-link"
                  :class="{ active: childNavItem == 28 }"
                >
                  <i class="fas fa-link nav-icon" aria-hidden="true"></i>
                  <p>Type </p>
                </router-link> 
              </li>   -->
            </ul>
          </li>    <!-- end of BUS -->                         

          <li v-if="isSuperAdmin" class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>MANAGEMENT
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link :to="{name:'bus-schedules'}" class="nav-link">
                    <i class="fas fa-clock nav-icon" aria-hidden="true"></i>
                    <p>Bus Schedules</p>
                </router-link> 
                </li>                   

                <li class="nav-item">
                  <router-link :to="{name:'route-cities'}" class="nav-link">
                      <i class="fas fa-map-signs nav-icon" aria-hidden="true"></i>
                      <p>Route Cities</p>
                  </router-link> 
                </li>                          
            </ul>
          </li> <!--  end of management -->                          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">            
            <router-link :to="{ name: 'dashboard' }" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard Home
              </p>              
            </router-link>
          </li>
          <li class="nav-item">            
            <router-link :to="{ name: 'first' }" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                First page
              </p>              
            </router-link>
          </li>          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
    export default {
      props: ['role'],
      data() {
        return {
          navItem: undefined,
          childNavItem: undefined,
          sidebarScroll: undefined,
        }
      },
      mounted() {
          console.log('Sidebar mounted.')
          // this.isSuperAdmin();
          this.enableScrollbar();
      },
      beforeUnmount() {
        this.sidebarScroll.destroy();
      },
      computed: {
        isSuperAdmin() {
          return (this.role == 'super_admin') ?
                true : false
        }
      },
      methods: {
        enableScrollbar() {
          this.sidebarScroll = OverlayScrollbars(document.getElementsByClassName("sidebar"),
            { /* your options */ 
              className: "os-theme-light",
              sizeAutoCapable: true,
              scrollbars: {
                autoHide: "never",
                clickScrolling: true
              } 
            })
        },
        toggleActive(activeSelection, childItem = true) {
          if (!childItem) {            
            this.navItem = activeSelection;
            return;
          }

          this.childNavItem = activeSelection;
          // this.navItem =  ( this.navItem !== activeSelection ) ? 
          //    activeSelection : undefined 
        },
      }
    }
</script>
<style lang="scss">
  .sidebar {
    height: calc(100vh - (3.5rem + 1px));
  }
</style>