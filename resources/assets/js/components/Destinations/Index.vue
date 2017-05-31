<template>
    <div class="content-wrapper">
        <header class="page-head">
            <div class="page-head">
                <h1>Destinations</h1>
            </div>
        </header>
        <!-- Main content -->
        <section class="main-content">
            <tabs>
                <tab name="Users" title="Users" active=true>
                    <div id="users">
                        <v-server-table url="/api/v1/destinations" :columns="columns" :options="options"></v-server-table>
                    </div>
                </tab>
            </tabs>
        </section>
    </div>
</template>
<script>
    import tabs from '../../components/Util/Tabs.vue'
    import tab from '../../components/Util/Tab.vue'
    export default {
        data() {
            return {
                columns: ['id', 'name'],
                options: {
                    templates: {
                        erase: function (h, row) {
                            return ''
                        }
                    }
                }
            }
        },
        components: {
            tabs, tab
        }
    }
</script>