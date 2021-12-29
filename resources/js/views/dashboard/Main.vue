<template>

    <div class="wrapper">

        <dashboard-header
            :user="JSON.parse(user)"            
        />  

        <sidebar 
            :user="JSON.parse(user)"            
            :role="role"            
            :home="homeRoute"
            :logout="logoutRoute"
        />

        <content-wrapper 
            :user="JSON.parse(user)"            
            :role="role"            
            :token="token"            
        />

        <controlbar />

        <!-- <dashboard-footer :show="showFooterToDashboardOnly"/> -->
        <dashboard-footer />
    </div>
</template>

<script>
    // import * as AdminLTE from 'admin-lte/build/js/AdminLTE';
    import { 
        ControlSidebar,
        Layout,
        PushMenu,
        Treeview,
        // DirectChat,
        // TodoList,
        // CardWidget,
        // CardRefresh,
        Dropdown,
        // Toasts
    } from 'admin-lte/build/js/AdminLTE';

    import ContentWrapper from './Content';
    import Controlbar from './Controlbar';
    import Sidebar from './Sidebar';
    import Header from './Header';
    import Footer from './Footer';

    export default {        
        props: [
            'user',
            'role',
            'token',
            'homeRoute',
            'logoutRoute'
        ],
        components: {
            ContentWrapper,
            Controlbar,
            Sidebar,
            DashboardHeader: Header,
            DashboardFooter: Footer
        },               
        mounted() {
          console.log('main mounted');
          this.toggleBodyClass('add', ['hold-transition', 'sidebar-mini', 'sidebar-mini-md', 'layout-fixed', 'layout-boxed']);
          // if (this.token) {
          //   console.log('t1', this.token)
          //   // this.setLocalStorage(this.token);
          //   this.setSessionFor(this.token);
          // }
        },
        unmounted() {
          this.toggleBodyClass('remove', ['hold-transition', 'sidebar-mini', 'sidebar-mini-md', 'layout-fixed', 'layout-boxed']);
        },
        computed: {
            // showFooterToDashboardOnly() {
            //     // console.log('main', this.$route);
            //     if (this.$route.name == 'dashboard') {
            //         return true;
            //     }
            //     return false;
            // }
        },
        methods: {            
            // setLocalStorage(token) {
            setSessionFor(token) {
                console.log('tm', token)
                // localStorage.setItem('token', token)
                sessionStorage.setItem('token', token)

            },
            toggleBodyClass(actionType, className) {
                const el = document.body;                
                el.classList[actionType](...className);
            },
            // removeSideBarMini(actionType, className) {
            //     const el = document.body;                
            //     el.classList[actionType](...className);
            // },
        },
    }
</script>
<style lang="scss">
    // @import '~admin-lte/build/scss/AdminLTE';    
    .content-wrapper > .content {
        padding: 0 1rem;
    }

    // .layout-fixed .control-sidebar {
    //     position: absolute;
    // }
    // .control-sidebar {
    //     z-index: 9999;
    // }
    // .control-sidebar::before {
    //     position: absolute;
    // }
</style>