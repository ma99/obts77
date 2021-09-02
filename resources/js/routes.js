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
        path: '/dashboard/admin/city',
        name: 'city',
        component: require('./views/city/City').default
    },
    {
        path: '/dashboard/admin/stop',
        name: 'stop',
        component: require('./views/city/Stop').default
    },
    // user
    {
        path: '/user/dashboard',
        component: require('./views/Home').default,
        name: 'userDashboard'
      
    },
    //404
    {   
        path: '/:pathMatch(.*)*', 
        name: 'NotFound',
        component: require('./views/Fourohfour').default
    },
];