import { createRouter, createWebHistory } from 'vue-router';

const isLogged = localStorage.getItem('logged') === 'Y';

const routes = [
  {
    path: '/',
    name: 'Dashboard',
    redirect: !isLogged ? '/auth' : '',
    component: () => import('@/views/backoffice/Dashboard.vue'),
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue'),
  },
  {
    path: '/auth',
    name: 'BoAuthentication',
    redirect: isLogged ? '/' : '',
    component: () => import('@/views/backoffice/auth/Authentication.vue'),
  },
  {
    path: '/auth/two-factor',
    name: 'Bo2FA',
    redirect: isLogged ? '/' : '',
    component: () => import('@/views/backoffice/auth/TFAuth.vue'),
  },
  {
    path: '/forgot-password',
    name: 'BoForgotPassword',
    redirect: isLogged ? '/' : '',
    component: () => import('@/views/backoffice/auth/ForgotPassword.vue'),
  },
  {
    path: '/reset-password',
    name: 'BoResetPassword',
    redirect: isLogged ? '/' : '',
    component: () => import('@/views/backoffice/auth/ResetPassword.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
