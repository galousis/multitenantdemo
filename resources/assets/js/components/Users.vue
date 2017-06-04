<template>
    <div class="content-wrapper">
        <header class="page-head">
            <div class="page-head">
                <h1>Users</h1>
            </div>
        </header>

        <!-- Main content -->
        <section class="main-content">

            <el-table
                    :data="tableData"
                    :default-sort = "{prop: 'id', order: 'ascending'}"
                    border
                    style="width: 100%">
                <el-table-column
                        label="ID"
                        prop="id"
                        sortable
                        width="180">
                    <template scope="scope">
                        <span style="margin-left: 10px">{{ scope.row.id}}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="Name"
                        width="280">
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
                        label="Email"
                        width="280">
                    <template scope="scope">
                        <el-popover trigger="hover" placement="top">
                            <p>Email: {{ scope.row.email}}</p>
                            <div slot="reference" class="name-wrapper">
                                <el-tag>{{ scope.row.email }}</el-tag>
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
            <!-- Pagination block -->
            <div class="block">
                <div class="pagination">
                    <button class="btn btn-default" @click="fetchTours(paginationT.prev_page_url)" :disabled="!paginationT.prev_page_url">
                        Previous
                    </button>
                    <span>Page {{paginationT.current_page}} of {{paginationT.last_page}}</span>
                    <button class="btn btn-default" @click="fetchTours(paginationT.next_page_url)" :disabled="!paginationT.next_page_url">Next
                    </button>
                </div>
            </div>

        </section>


    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData: [],
                paginationT: {}
            }
        },
        created: function () {
            this.fetchTours()
        },
        methods: {
            handleEdit(index, row) {
                console.log(index, row);
            },
            handleDelete(index, row) {
                console.log(index, row);
            },
            handleSizeChange(val) {
                console.log(`${val} items per page`);
            },
            handleCurrentChange(val) {
                console.log(`current page: ${val}`);
            },
            fetchTours: function (page_url) {
                let vm = this;

                page_url = page_url || '/api/v1/users';

                return this.$http.get(page_url).then((response) => {

                    vm.tableData = response.data.data;
                    vm.paginationT = vm.makePagination(response.data);

                    console.log(response.data);
                });
            },
            makePagination: function (data){
                //here we use response.data
                var pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url
                }
                return pagination;

            }
        }
    }
</script>
