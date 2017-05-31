/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

/*
 * vue router inclusion
 * */
import VueRouter from "vue-router";
import auth from "./auth";
import App from "./components/App.vue";
import Container from "./components/Container.vue";
import About from "./components/About.vue";
import Dashboard from "./components/Dashboard.vue";
import Login from "./components/Auth/Login.vue";
import Register from "./components/Auth/Register.vue";
import ForgotPassword from "./components/Auth/ForgotPassword.vue";
import Users from "./components/Users.vue";
//import Passport from "./components/passport/Index.vue";
import Destinations from "./components/Destinations/Index.vue";
import Tours from "./components/Tours/Index.vue";

var VueResource = require('vue-resource');
var VueTables = require('vue-tables-2');

//import Vuetify from 'vuetify'
//Vue.use(Vuetify);

import {
    Pagination,
    Dialog,
    Autocomplete,
    Dropdown,
    DropdownMenu,
    DropdownItem,
    Menu,
    Submenu,
    MenuItem,
    MenuItemGroup,
    Input,
    InputNumber,
    Radio,
    RadioGroup,
    RadioButton,
    Checkbox,
    CheckboxGroup,
    Switch,
    Select,
    Option,
    OptionGroup,
    Button,
    ButtonGroup,
    Table,
    TableColumn,
    DatePicker,
    TimeSelect,
    TimePicker,
    Popover,
    Tooltip,
    Breadcrumb,
    BreadcrumbItem,
    Form,
    FormItem,
    Tabs,
    TabPane,
    Tag,
    Tree,
    Alert,
    Slider,
    Icon,
    Row,
    Col,
    Upload,
    Progress,
    Spinner,
    Badge,
    Card,
    Rate,
    Steps,
    Step,
    Carousel,
    Scrollbar,
    CarouselItem,
    Collapse,
    CollapseItem,
    Cascader,
    ColorPicker,
    Loading,
    MessageBox,
    Message
} from 'element-ui'

Vue.use(Pagination)
Vue.use(Dialog)
Vue.use(Autocomplete)
Vue.use(Dropdown)
Vue.use(DropdownMenu)
Vue.use(DropdownItem)
Vue.use(Menu)
Vue.use(Submenu)
Vue.use(MenuItem)
Vue.use(MenuItemGroup)
Vue.use(Input)
Vue.use(InputNumber)
Vue.use(Radio)
Vue.use(RadioGroup)
Vue.use(RadioButton)
Vue.use(Checkbox)
Vue.use(CheckboxGroup)
Vue.use(Switch)
Vue.use(Select)
Vue.use(Option)
Vue.use(OptionGroup)
Vue.use(Button)
Vue.use(ButtonGroup)
Vue.use(Table)
Vue.use(TableColumn)
Vue.use(DatePicker)
Vue.use(TimeSelect)
Vue.use(TimePicker)
Vue.use(Popover)
Vue.use(Tooltip)
Vue.use(Breadcrumb)
Vue.use(BreadcrumbItem)
Vue.use(Form)
Vue.use(FormItem)
Vue.use(Tabs)
Vue.use(TabPane)
Vue.use(Tag)
Vue.use(Tree)
Vue.use(Alert)
Vue.use(Slider)
Vue.use(Icon)
Vue.use(Row)
Vue.use(Col)
Vue.use(Upload)
Vue.use(Progress)
Vue.use(Spinner)
Vue.use(Badge)
Vue.use(Card)
Vue.use(Rate)
Vue.use(Steps)
Vue.use(Step)
Vue.use(Carousel)
Vue.use(Scrollbar)
Vue.use(CarouselItem)
Vue.use(Collapse)
Vue.use(CollapseItem)
Vue.use(Cascader)
Vue.use(ColorPicker)

Vue.use(Loading.directive)

Vue.prototype.$loading = Loading.service
Vue.prototype.$msgbox = MessageBox
Vue.prototype.$alert = MessageBox.alert
Vue.prototype.$confirm = MessageBox.confirm
Vue.prototype.$prompt = MessageBox.prompt
Vue.prototype.$notify = Notification
Vue.prototype.$message = Message

/*
 * import
 * components
 * */


Vue.use(VueResource);
Vue.use(VueRouter);
Vue.use(VueTables.client);
Vue.use(VueTables.server);

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

Vue.http.interceptors.push((request, next) => {
    request.headers['X-CSRF-TOKEN'] = Laravel.csrfToken;
    next();
});
//Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
/*
 * components
 * */
const Default = {template: '<div>default</div>'}
const Foo = {template: '<div>foo</div>'}
const Bar = {template: '<div>bar</div>'}
const Baz = {template: '<div>baz</div>'}


const router = new VueRouter({
    mode: 'hash',
    base: __dirname,
    routes: [
        {
            path: '/',
            component: Container,
            meta: {requiresAuth: true},
            children: [
                // an empty path will be treated as the default, e.g.
                // components rendered at /parent: Root -> Parent -> Default
                {path: '', component: Dashboard},

                // components rendered at /parent/foo: Root -> Parent -> Foo
                {path: 'users', component: Users},
                {path: 'destinations', component: Destinations},
                {path: 'tours', component: Tours},

                // components rendered at /parent/bar: Root -> Parent -> Bar
                {path: 'bar', component: Bar},

                // NOTE absolute path here!
                // this allows you to leverage the component nesting without being
                // limited to the nested URL.
                // components rendered at /baz: Root -> Parent -> Baz
                {path: '/baz', component: Baz}
            ]
        },

        {
            path: '/about',
            component: About,
            meta: {requiresAuth: true},
            children: [
                // an empty path will be treated as the default, e.g.
                // components rendered at /parent: Root -> Parent -> Default
                {path: '', component: Dashboard},

                // components rendered at /parent/foo: Root -> Parent -> Foo
                {path: 'foo', component: Foo},

                // components rendered at /parent/bar: Root -> Parent -> Bar
                {path: 'bar', component: Bar},

                // NOTE absolute path here!
                // this allows you to leverage the component nesting without being
                // limited to the nested URL.
                // components rendered at /baz: Root -> Parent -> Baz
                {path: '/baz', component: Baz}
            ]
        },
        {
            path: '/login',
            component: Login
        },
        {
            path: '/forgot-password',
            component: ForgotPassword
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/logout',
            beforeEnter (to, from, next) {
                auth.logout();
                next('/login')
            }
        }
    ]
});
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!auth.loggedIn()) {
             next({
                path: '/login',
                query: {redirect: to.fullPath}
            })
        } else {
            Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
            next()
        }
    } else {
        next(); // make sure to always call next()!
    }
});

// Vue.http.interceptors.push((request, next) => {
//     // continue to next interceptor
//     next((response) => {
//         if (response.status == 401) {
//             auth.logout();
//         }
//     });
//
// });

// 4. Create and mount the root instance.
// Make sure to inject the router with the router option to make the
// whole app router-aware.

new Vue(Vue.util.extend({router}, App)).$mount('#app');

/*
 * fils delete
 * reciepent end progress and compress download
 * simple files -> smallfiles
 *
 * */