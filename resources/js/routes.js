const Home = () => import('./components/Home.vue');
const Searches = () => import('./components/Searches.vue');

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
    }
];