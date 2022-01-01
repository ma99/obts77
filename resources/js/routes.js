// export const  routes = [
//     {
//       path: '/dashboard/admin/first-page',      
//       component: require('./views/First').default,
//       name: 'first'
//     },
//     {
//       path: '/dashboard/admin/second-page',
//       component: require('./views/Second').default,
//       name: 'second'
//     },
//     {
//       path: '/dashboard/admin/dashboard',
//       component: require('./views/Home').default,
//       name: 'dashboard'
//     },
// ]
export const routes = [    
    {
      path: '/dashboard/admin/first-page',      
      name: 'first',
      component: require('./views/First').default
    },
    {
      path: '/dashboard/admin/second-page',
      component: require('./views/Second').default,
      name: 'second'
    },
    {
        path: '/dashboard/admin',
        component: require('./views/Home').default,
        name: 'dashboard'
      
    },
    {
        //path: '/about',
        path: '/dashboard/admin/about',
        component: require('./views/About').default
    },
    {
        path: '/dashboard/admin/contact',
        component: require('./views/Contact').default
    },
    // {
    //     path: '/dashboard/admin/staff-management',
    //     component: require('./views/StaffManagement').default
    // },
    //User
    // {
    //     path: '/dashboard/admin/profile',
    //     component: require('./views/Profile').default
    // },
    // {
    //     path: '/dashboard/admin/roles',
    //     component: require('./views/Roles').default
    // },
    // {
    //     path: '/dashboard/admin/staff-list',
    //     component: require('./views/StaffList').default
    // },
    
    //User
    {
        path: '/dashboard/admin/user-role',
        name: 'user-role',
        component: require('./views/user/UserRole').default
    },
    //Bus 
    {
        path: '/dashboard/admin/bus',
        name: 'bus',
        component: require('./views/bus/Bus').default
    },
    {
        path: '/dashboard/admin/type',
        name: 'type',
        component: require('./views/bus/Type').default
    },
    {
        path: '/dashboard/admin/trip',
        name: 'trip',
        component: require('./views/bus/Trip').default
    },
    // {
    //     path: '/dashboard/admin/list',
    //     component: require('./views/bus/BusList').default
    // },
    {
        path: '/dashboard/admin/route',
        name: 'route',
        component: require('./views/route/Route').default
    },
    // {
    //     path: '/dashboard/admin/route-buses',
    //     component: require('./views/route/RouteBuses').default
    // },
    {
        path: '/dashboard/admin/route-cities',
        name: 'route-cities',
        component: require('./views/route/RouteCities').default
    },
    {
        path: '/dashboard/admin/seat-plan',
        name: 'seat-plan',
        component: require('./views/bus/SeatPlan').default
    },
    {
        path: '/dashboard/admin/fare',
        name: 'fare',
        component: require('./views/bus/Fare').default
    },
    {
        path: '/dashboard/admin/schedule',
        name: 'schedule',
        component: require('./views/bus/Schedule').default
    },
    {
        path: '/dashboard/admin/bus-schedules',
        name: 'bus-schedules',
        component: require('./views/bus/BusSchedules').default
    },
    {
        path: '/dashboard/admin/bus-staff',
        name: 'bus-staff',
        component: require('./views/bus/BusStaff').default
    },
    {
        path: '/dashboard/admin/city',
        name: 'city',
        component: require('./views/city/City').default
    },
    {
        path: '/dashboard/admin/stop',
        name: 'stop',
        component: require('./views/city/Stop').default
    },
    {
        path: '/dashboard/admin/stop',
        name: 'stop',
        component: require('./views/city/Stop').default
    },

    // Staff
    {
        path: '/dashboard/admin/staffs/driver',
        name: 'driver',
        component: require('./views/staffs/Driver').default
    },
    {
        path: '/dashboard/admin/staffs/supervisor',
        name: 'supervisor',
        component: require('./views/staffs/Supervisor').default
    },
    {
        path: '/dashboard/admin/staffs/helper',
        name: 'helper',
        component: require('./views/staffs/Helper').default
    },

    //Slider
    {
        path: '/dashboard/admin/slider/slide',
        name: 'slide',
        component: require('./views/slider/Slide').default
    },

    // Operations
    {
        path: '/dashboard/admin/tickets/cancel',
        name: 'cancel',
        component: require('./views/operations/ticket/Cancel').default
    },
    {
        path: '/dashboard/admin/tickets/refund',
        name: 'process-refund',
        component: require('./views/operations/ticket/ProcessRefund').default
    },

    // user
    {
        path: '/dashboard/user',
        component: require('./views/Home').default,
        name: 'user-dashboard'
      
    },
    {
        path: '/dashboard/user/tickets/refund',
        name: 'request-refund',
        component: require('./views/Operations/ticket/RequestRefund').default
    },
    {
        path: '/dashboard/user/notifications',
        component: require('./views/notification/Notifications').default,
        name: 'notifications'
      
    },
    {
        path: '/dashboard/user/notifications/:id',
        component: require('./views/notification/Notification').default,
        name: 'notification'
      
    },
    //404
    {   
        path: '/:pathMatch(.*)*', 
        name: 'NotFound',
        component: require('./views/Fourohfour').default
    },
];