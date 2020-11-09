// export const  routes = [
//     {
//       path: '/admin/first-page',      
//       component: require('./views/First').default,
//       name: 'first'
//     },
//     {
//       path: '/admin/second-page',
//       component: require('./views/Second').default,
//       name: 'second'
//     },
//     {
//       path: '/admin/dashboard',
//       component: require('./views/Home').default,
//       name: 'dashboard'
//     },
// ]
export const routes = [    
    {
      path: '/admin/first-page',      
      name: 'first',
      component: require('./views/First').default
    },
    {
      path: '/admin/second-page',
      component: require('./views/Second').default,
      name: 'second'
    },
    {
        path: '/admin/dashboard',
        component: require('./views/Home').default,
        name: 'dashboard'
      
    },
    {
        //path: '/about',
        path: '/admin/about',
        component: require('./views/About').default
    },
    {
        path: '/admin/contact',
        component: require('./views/Contact').default
    },
    // {
    //     path: '/admin/staff-management',
    //     component: require('./views/StaffManagement').default
    // },
    //User
    // {
    //     path: '/admin/profile',
    //     component: require('./views/Profile').default
    // },
    // {
    //     path: '/admin/roles',
    //     component: require('./views/Roles').default
    // },
    // {
    //     path: '/admin/staff-list',
    //     component: require('./views/StaffList').default
    // },
    //Bus 
    {
        path: '/admin/bus',
        name: 'bus',
        component: require('./views/bus/Bus').default
    },
    {
        path: '/admin/type',
        name: 'type',
        component: require('./views/bus/Type').default
    },
    // {
    //     path: '/admin/list',
    //     component: require('./views/bus/BusList').default
    // },
    {
        path: '/admin/route',
        name: 'route',
        component: require('./views/route/Route').default
    },
    // {
    //     path: '/admin/route-buses',
    //     component: require('./views/route/RouteBuses').default
    // },
    {
        path: '/admin/route-cities',
        name: 'route-cities',
        component: require('./views/route/RouteCities').default
    },
    {
        path: '/admin/seat-plan',
        name: 'seat-plan',
        component: require('./views/bus/SeatPlan').default
    },
    {
        path: '/admin/fare',
        name: 'fare',
        component: require('./views/bus/Fare').default
    },
    {
        path: '/admin/schedule',
        name: 'schedule',
        component: require('./views/bus/Schedule').default
    },
    {
        path: '/admin/bus-schedules',
        name: 'bus-schedules',
        component: require('./views/bus/BusSchedules').default
    },
    {
        path: '/admin/city',
        name: 'city',
        component: require('./views/city/City').default
    },
    {
        path: '/admin/stop',
        name: 'stop',
        component: require('./views/city/Stop').default
    },
    //404
    {   
        path: '/:pathMatch(.*)*', 
        name: 'NotFound',
        component: require('./views/Fourohfour').default
    },
];