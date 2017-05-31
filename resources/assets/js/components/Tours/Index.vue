<template>



    <div class="content-wrapper">

        <header class="page-head">
            <div class="page-head">
                <h1>Tours</h1>
            </div>
        </header>

        <!-- Main content -->
        <section class="main-content">

            <el-table
                    :data="tableData"
                    :default-sort = "{prop: 'id', order: 'descending'}"
                    border
                    style="width: 100%">
                <el-table-column
                        label="ID"
                        prop="id"
                        sortable
                        width="180">
                    <template scope="scope">
                        <el-icon name="time"></el-icon>
                        <span style="margin-left: 10px">{{ scope.row.id}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Name"
                        width="180">
                    <template scope="scope">
                        <el-popover trigger="hover" placement="top">
                            <p>Name: {{ scope.row.name }}</p>
                            <div slot="reference" class="name-wrapper">
                                <el-tag>{{ scope.row.name }}</el-tag>
                            </div>
                        </el-popover>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Operations">
                    <template scope="scope">
                        <el-button
                                size="small"
                                @click="handleEdit(scope.$index, scope.row)">Edit</el-button>
                        <el-button
                                size="small"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
                    </template>
                </el-table-column>
            </el-table>

            <Paginate></Paginate>

            <!--<el-table-->
                    <!--:data="tableData"-->
                    <!--:default-sort = "{prop: 'date', order: 'descending'}"-->
                    <!--border-->
                    <!--style="width: 100%">-->
                <!--<el-table-column-->
                        <!--label="Date"-->
                        <!--prop="date"-->
                        <!--sortable-->
                        <!--width="180">-->
                    <!--<template scope="scope">-->
                        <!--<el-icon name="time"></el-icon>-->
                        <!--<span style="margin-left: 10px">{{ scope.row.date }}</span>-->
                    <!--</template>-->
                <!--</el-table-column>-->
                <!--<el-table-column-->
                        <!--label="Name"-->
                        <!--width="180">-->
                    <!--<template scope="scope">-->
                        <!--<el-popover trigger="hover" placement="top">-->
                            <!--<p>Name: {{ scope.row.name }}</p>-->
                            <!--<p>Addr: {{ scope.row.address }}</p>-->
                            <!--<div slot="reference" class="name-wrapper">-->
                                <!--<el-tag>{{ scope.row.name }}</el-tag>-->
                            <!--</div>-->
                        <!--</el-popover>-->
                    <!--</template>-->
                <!--</el-table-column>-->
                <!--<el-table-column-->
                        <!--label="Operations">-->
                    <!--<template scope="scope">-->
                        <!--<el-button-->
                                <!--size="small"-->
                                <!--@click="handleEdit(scope.$index, scope.row)">Edit</el-button>-->
                        <!--<el-button-->
                                <!--size="small"-->
                                <!--type="danger"-->
                                <!--@click="handleDelete(scope.$index, scope.row)">Delete</el-button>-->
                    <!--</template>-->
                <!--</el-table-column>-->
            <!--</el-table>-->

        </section>


    </div>
</template>

<script>
    import Paginate from "../../components/Paginate.vue";
    export default {
        data() {
            return {
                tableData: []
            }
        },
        methods: {
            handleEdit(index, row) {
                console.log(index, row);
            },
            handleDelete(index, row) {
                console.log(index, row);
            }
        },
        created() {
            let vm = this;

            return this.$http.get('/api/v1/tours').then((response) => {

                vm.tableData = response.data;
                console.log(response.data);
            });
        },
        components: {
            Paginate
        }
    }
</script>

