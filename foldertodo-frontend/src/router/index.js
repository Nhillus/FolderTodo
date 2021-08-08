import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeTodo from '../views/HomeTodo.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'HomeTodo',
    component: HomeTodo
  },
  {
    path: '/about',
    name: 'About',
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
