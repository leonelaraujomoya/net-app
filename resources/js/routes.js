const Home = () => import('./components/Home.vue');
const Searches = () => import('./components/Searches.vue');
const Viewvideo = () => import('./components/Viewvideo.vue');

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'searches',
        path: '/searches/:details',
        component: Searches,
        props: true
    },
    {
        name: 'viewvideo',
        path: '/viewvideo/:video_details',
        component: Viewvideo,
        props: true
    }
];