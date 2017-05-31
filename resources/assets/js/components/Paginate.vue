<template>
    <div class="block">
        <span class="demonstration">Change page size</span>
        <el-pagination
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :current-page.sync="currentPage2"
                :page-sizes="[100, 200, 300, 400]"
                :page-size="100"
                layout="sizes, prev, pager, next"
                :total="1000">
        </el-pagination>
    </div>
</template>
<script>
    export default {
        methods: {
            handleSizeChange(val) {
                console.log(`${val} items per page`);
            },
            handleCurrentChange(val) {
                console.log(`current page: ${val}`);
            }
        },
        data() {
            return {
                currentPage1: 5,
                currentPage2: 5,
                currentPage3: 5,
                currentPage4: 4
            };
        }
    }
</script>

<style>

    .demo-pagination .source.first{padding:0}.demo-pagination .first .block{padding:30px 0;text-align:center;border-right:1px solid #eff2f6;float:left;width:50%;box-sizing:border-box}.demo-pagination .first .block:last-child{border-right:none}.demo-pagination .first .demonstration{display:block;color:#8492a6;font-size:14px;margin-bottom:20px}.demo-pagination .source.last{padding:0}.demo-pagination .last .block{padding:30px 24px;border-bottom:1px solid #eff2f6}.demo-pagination .last .block:last-child{border-bottom:none}.demo-pagination .last .demonstration{font-size:14px;color:#8492a6;line-height:44px}.demo-pagination .last .demonstration+.el-pagination{float:right;width:70%;margin:5px 20px 0 0}

</style>