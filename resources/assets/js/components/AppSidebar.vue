<template>
    <div>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar Menu -->
                <el-menu class="el-menu-vertical-demo">
                    <el-menu-item index="1" @click="openPage"><i class="el-icon-menu"></i>Dashboard</el-menu-item>
                    <el-menu-item index="2" @click="openPage"><i class="el-icon-menu"></i>Users</el-menu-item>
                    <el-menu-item index="3" @click="openPage"><i class="el-icon-menu"></i>Tours</el-menu-item>
                    <el-menu-item index="4" @click="openPage"><i class="el-icon-setting"></i>Destinations</el-menu-item>
                </el-menu>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
    </div>
</template>

<script>
    export default {
        ready() {
            //console.log('Component ready.')
        },
        data(){
            return {
                message: "side Bar "
            }

        },
        methods: {
            openPage : function (event) {

//                if (event) {
//                    console.log(event.$el.innerText);
//                }

                switch(event.$el.innerText) {
                    case 'Dashborad':
                        this.$router.push({path: '/'});
                        break;
                    case 'Users':
                        this.$router.push({path: '/users'});
                        break;
                    case 'Tours':
                        this.$router.push({path: '/tours'});
                        break;
                    case 'Destinations':
                        this.$router.push({path: '/destinations'});
                        break;
                    default:
                        this.$router.push({path: '/'});
                        break;
                }
            }
        },
        computed: {
            demo: function () {
                return {
                    displayName: "smaple",
                    avatar: "smaple",
                    email: "smaple",
                    randomCard: "smaple",
                }
            }
        }
    }
</script>
