<template>
    <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a :href="home" class="brand-link">
      <img src="/dashboard/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">B<i><strong>T</strong></i>MS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column">
        <div class="d-flex info" :class="{ active: expand }">          
          <div class="image">
            <img src="/dashboard/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="px-2 py-1 w-100" @click="expand=!expand">
            <a>
              {{user.name}}
            </a>            
            <span class="float-right">
              <transition name="fade" mode="out-in">
                <span> 
                  <i v-show="!expand" class="far fa-plus-square text-secondary"></i>
                  <i v-show="expand" class="far fa-minus-square text-light"></i>
                </span>
              </transition>
            </span>                
          </div>
        </div>
        <div class="flex mt-2">
          <span 
            class="mx-3 badge" 
            :class="[activeBadge]">{{role}}
          </span>
        </div>
        <div class="d-flex mt-3 justify-content-center">          
          <div class="list-group"  v-show="expand">
            <a href="#" class="list-group-item list-group-item-action">
              <i class="far fa-id-card mr-2"></i>Profile
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              <i class="far fa-list-alt mr-2"></i>My Orders
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              <i class="far fa-share-square mr-2"></i>Returns & Refunds
            </a>
            <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
          </div>            
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
            <a href="#" class="nav-link"
              :class="{ active: navItem == 3 }"
              @click="toggleActive(3, false)"
            >
              <i class="nav-icon fas fa-cogs text-warning"></i>
              <p>MANAGEMENT
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item" @click="toggleActive(31)">
                <router-link :to="{name:'user-role'}" 
                  class="nav-link"
                  :class="{ active: childNavItem == 31 }"
                >
                  <i class="fas fa-user nav-icon" aria-hidden="true"></i>
                  <p>User Role</p>
              </router-link> 
              </li>                   

              <li class="nav-item" @click="toggleActive(34)">
                <router-link :to="{name:'bus-staff'}" 
                  class="nav-link"
                  :class="{ active: childNavItem == 34 }"
                >
                    <i class="fas fa-users-cog nav-icon" aria-hidden="true"></i>
                    <p>Bus Staff</p>
                </router-link> 
              </li>

              <li class="nav-item" @click="toggleActive(32)">
                <router-link :to="{name:'bus-schedules'}" 
                  class="nav-link"
                  :class="{ active: childNavItem == 32 }"
                >
                    <i class="fas fa-clock nav-icon" aria-hidden="true"></i>
                    <p>Bus Schedules</p>
                </router-link> 
              </li>                   

              <li class="nav-item" @click="toggleActive(33)">
                  <router-link :to="{name:'route-cities'}" 
                    class="nav-link"
                    :class="{ active: childNavItem == 33 }"
                  >
                      <i class="fas fa-map-signs nav-icon" aria-hidden="true"></i>
                      <p>Route Cities</p>
                  </router-link> 
                </li>                
            </ul>
            <!-- staff                           -->
                <!-- level-2 -->
              <ul class="nav nav-treeview">      
                <!-- note: remove 'menu-open' -->          
                <li class="nav-item has-treeview menu-open">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon text-warning"></i>
                    <p>
                      STAFF
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <!-- level-3 -->
                  <ul class="nav nav-treeview">
                    <li class="nav-item" @click="toggleActive(34)">
                      <router-link :to="{name:'driver'}" 
                        class="nav-link"
                        :class="{ active: childNavItem == 34 }"
                      >
                        <i class="far fa-dot-circle nav-icon text-warning"></i>
                        <p>Driver</p>
                      </router-link>
                    </li>                    
                    <li class="nav-item" @click="toggleActive(35)">
                      <router-link :to="{name:'supervisor'}"
                      class="nav-link"
                      :class="{ active: childNavItem == 35 }"
                      >
                        <i class="far fa-dot-circle nav-icon text-warning"></i>
                        <p>Supervisor</p>
                      </router-link>
                    </li>
                    <li class="nav-item" @click="toggleActive(36)">
                      <router-link :to="{name:'helper'}"
                      class="nav-link"
                      :class="{ active: childNavItem == 36 }"
                      >
                        <i class="far fa-dot-circle nav-icon text-warning"></i>
                        <p>Helper</p>
                      </router-link>
                    </li>
                  </ul>
                </li>              
              </ul>
              <!-- end -->
          </li> 
            <!-- note: remove 'menu-open' -->
            <li v-if="isAdmin" class="nav-item has-treeview"> 
              <a href="#" class="nav-link"
                :class="{ active: navItem == 4 }"
                @click="toggleActive(4, false)"
              >
                <i class="nav-icon fas fa-circle"></i>
                <p>
                <!-- level-1 -->
                  OPERATIONS
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <!-- level-2 -->
              <ul class="nav nav-treeview">      
                <!-- note: remove 'menu-open' -->          
                <li class="nav-item has-treeview menu-open">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>
                      TICKETS
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <!-- level-3 -->
                  <ul class="nav nav-treeview">
                    <li class="nav-item" @click="toggleActive(41)">
                      <router-link :to="{name:'cancel'}" 
                        class="nav-link"
                        :class="{ active: childNavItem == 41 }"
                      >
                        <i class="far fa-dot-circle nav-icon text-success"></i>
                        <p>Cancel</p>
                      </router-link>
                    </li>                    
                    <li class="nav-item" @click="toggleActive(42)">
                      <router-link :to="{name:'processRefund'}"
                      class="nav-link"
                      :class="{ active: childNavItem == 42 }"
                      >
                        <i class="far fa-dot-circle nav-icon text-success"></i>
                        <p>Process Refund</p>
                      </router-link>
                    </li>
                  </ul>
                </li>              
              </ul>
              <!-- level-2 -->
              <ul class="nav nav-treeview">                
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Level 2
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <!-- level-3 -->
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Level 3</p>
                      </a>
                    </li>                    
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Level 3</p>
                      </a>
                    </li>
                  </ul>
                </li>              
              </ul>
            </li>

            <!-- User -->
            <li v-else class="nav-item has-treeview menu-open"> 
              <a href="#" class="nav-link"
                :class="{ active: navItem == 4 }"
                @click="toggleActive(4, false)"
              >
                <i class="nav-icon fas fa-circle"></i>
                <p>
                <!-- level-1 -->
                  OPERATIONS
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <!-- level-2 -->
              <ul class="nav nav-treeview">      
                <!-- note: remove 'menu-open' -->          
                <li class="nav-item has-treeview menu-open">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon text-success"></i>
                    <p>
                      TICKETS
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <!-- level-3 -->
                  <ul class="nav nav-treeview">
                    <li class="nav-item" @click="toggleActive(41)">
                      <router-link :to="{name:'cancel'}" 
                        class="nav-link"
                        :class="{ active: childNavItem == 41 }"
                      >
                        <i class="far fa-dot-circle nav-icon text-success"></i>
                        <p>Cancel</p>
                      </router-link>
                    </li>                    
                    <li class="nav-item" @click="toggleActive(42)">
                      <router-link :to="{name:'requestRefund'}"
                      class="nav-link"
                      :class="{ active: childNavItem == 42 }"
                      >
                        <i class="far fa-dot-circle nav-icon text-success"></i>
                        <p>Request Refund</p>
                      </router-link>
                    </li>
                  </ul>
                </li>              
              </ul>
              <!-- level-2 -->
              <ul class="nav nav-treeview">                
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                      Level 2
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <!-- level-3 -->
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Level 3</p>
                      </a>
                    </li>                    
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>Level 3</p>
                      </a>
                    </li>
                  </ul>
                </li>              
              </ul>
            </li>
            
          <!-- </li>  end of operations                           -->

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
          <li class="nav-item">            
            <!-- <router-link :to="{ name: 'first' }" class="nav-link"> -->              
            <div>
              <form method="post" :action="logout">
                <csrf-token />
                <div class="form-group my-3">
                  <button type="submit" class="btn btn-warning btn-block">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                  Logout
                </button>
                </div>
              </form>  
            </div>              
            <!-- </router-link> -->
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
      props: {
        home: String,
        logout: String,
        role: String,
        user: {
          type: Object
        },
        name: '',
      },
      data() {
        return {
          activeBadge: this.activeBadgeSelection(),
          expand: false,
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
        },
        isAdmin() {
          return (this.role == 'super_admin' || this.role == 'admin') ?
                true : false
        },                
      },
      methods: {
        activeBadgeSelection() {
          var activeBadge = null;
          if(this.role) {
            switch(this.role) {
              case 'super_admin':
                  activeBadge = 'badge-danger';
                  break;
              case 'admin':
                  activeBadge = 'badge-warning';
                  break;
              case 'operator':
                activeBadge = 'badge-success';
                break;
            }
          }
          return activeBadge;  
        },
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
<style lang="scss" scoped>
  .sidebar {
    height: calc(100vh - (3.5rem + 1px));

    // .list-group {      
    //   .list-group-item {  
    //     background-color: hsla(210, 16%, 27%, 1);      
    //     .list-group-item-action a:hover {
    //       color: hsla(211, 100%, 31%, 1) !important;
    //     }
    //   }
    // }

  }
  .list-group-item {
      background-color: hsla(210, 16%, 27%, 1);      
  }
  .user-panel {
   a:hover {
    color: hsla(211, 100%, 50%, 1) !important; 
   }
   .info {
      border-radius: 3px; 
     &:hover {
        background-color: hsla(210, 6%, 31%, 1);
        cursor: pointer;
      }
      &.active {
        background-color: hsla(188, 78%, 41%, 1);
      }  
    }    
  }
  .list-group-item-action {
    &:hover, &:focus {
      color: hsla(210, 17%, 98%, 1) !important;
      background-color: hsla(210, 18%, 35%, 1);
    }
  }
  .fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>